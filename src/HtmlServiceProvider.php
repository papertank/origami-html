<?php

namespace Origami\Html;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Html::class);
        $this->app->alias(Html::class, 'origami-html');

        $this->app->singleton(HtmlBuilder::class);
        $this->app->alias(HtmlBuilder::class, 'origami-html.html');

        $this->app->singleton(FormBuilder::class);
        $this->app->alias(FormBuilder::class, 'origami-html.form');
    }

    public function boot()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['origami-html', 'origami-html.html', 'origami-html.form'];
    }
}
