<?php namespace VnsModules\Menu;

use Illuminate\Support\ServiceProvider;
use VnSource\Traits\ModuleServiceProviderTrait;

class ModuleServiceProvider extends ServiceProvider
{
    use ModuleServiceProviderTrait;

    public $hookView = [
        'admin.layout' => 'hook.admin'
    ];
    public $gadget = [
        'menu' => [
            'callback' => 'VnsModules\Menu\Gadget',
            'name' => 'Menu',
            'description' => 'Giúp khách truy cập dễ dàng điều hướng tới blog của bạn bằng liên kết đến các bài đăng cũ hơn. ',
            'parameters' => [
                'slug' => [
                    'type' => 'text',
                    'label' => 'Slug'
                ]
            ]
        ]
    ];
    public $permissions = [
        'menu' => 'Menu management'
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->initializationModule();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            MenuRepositoryInterface::class,
            MenuRepository::class
        );
    }
}
