<?php

namespace App\MyProject\Common\Console;

use App\MyProject\Common\Enum\PermissionEnum;
use App\MyProject\Common\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupCommand extends Command
{

    protected $signature = 'ciliatus:setup {--db-only}';

    protected $description = 'Initial Setup';

    public function handle()
    {
        echo '# Generating app key ...' . PHP_EOL;
        Artisan::call('key:generate');

        if (!$this->option('db-only')) {
            echo '# Setting up authentication provider ...' . PHP_EOL;
            Artisan::call('vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"');
            Artisan::call('jetstream:install livewire');
        }

        echo '# Setting up queues ...' . PHP_EOL;
        Artisan::call('queue:table');

        echo '# Migrating database ...' . PHP_EOL;
        Artisan::call('migrate');

        echo '# Setting up defaults ...' . PHP_EOL;
        $defaults = [
            'Core' => [
                'location_types',
                'habitat_types',
                'animal_classes',
                'animal_species'
            ],
            'Monitoring' => [
                'physical_sensor_types',
                'logical_sensor_types'
            ],
            'Automation' => [
                'appliance_capabilities',
                'appliance_types',
                'appliance_type_states'
            ]
        ];

        foreach ($defaults as $namespace => $files) {
            foreach ($files as $file) {
                $default = include __DIR__ . '/../../' . $namespace . '/Database/default/' . $file . '.php';
                echo "Creating " . $file . " ..." . PHP_EOL;
                $class = $default['model'];
                if (isset($default['items'])) {
                    foreach ($default['items'] as $item) {
                        $class::create($item);
                    }
                }

                if (isset($default['attach'])) {
                    foreach ($default['attach'] as $id => $relations) {
                        foreach ($relations as $attach) {
                            $model = $default['model']::find($id);
                            $relation = $attach['relation'];
                            $model->$relation()->attach($attach['id']);
                        }
                    }
                }
            }
        }

        $password = 'a'; #Str::random(10);
        $user = [
            'name' => 'Admin',
            'email' => 'a@a.aa', #' Str::random(6) . '@ciliatus.io',
            'password' => bcrypt($password)
        ];

        /** @var User $superadmin */
        $superadmin = User::create($user);
        $superadmin->syncPermissions([
            'Api' => [PermissionEnum::PERMISSION_READ(), PermissionEnum::PERMISSION_WRITE(), PermissionEnum::PERMISSION_ADMIN()],
            'Automation' => [PermissionEnum::PERMISSION_READ(), PermissionEnum::PERMISSION_WRITE(), PermissionEnum::PERMISSION_ADMIN()],
            'Common' => [PermissionEnum::PERMISSION_READ(), PermissionEnum::PERMISSION_WRITE(), PermissionEnum::PERMISSION_ADMIN()],
            'Core' => [PermissionEnum::PERMISSION_READ(), PermissionEnum::PERMISSION_WRITE(), PermissionEnum::PERMISSION_ADMIN()],
            'Monitoring' => [PermissionEnum::PERMISSION_READ(), PermissionEnum::PERMISSION_WRITE(), PermissionEnum::PERMISSION_ADMIN()]
        ]);

        echo "################################" . PHP_EOL;
        echo "######### Initial User #########" . PHP_EOL;
        echo "# Username: " . $user['email'] . " #" . PHP_EOL;
        echo "# Password: " . $password . " #########" . PHP_EOL;
        echo "# Token: " . $superadmin->createToken('test')->plainTextToken . PHP_EOL;
        echo "################################" . PHP_EOL;

        echo "Setup done" . PHP_EOL;
    }

}
