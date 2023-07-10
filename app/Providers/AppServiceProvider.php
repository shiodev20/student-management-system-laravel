<?php

namespace App\Providers;

use App\Models\Semester;
use App\Models\Year;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Paginator::useBootstrapFour();
    view()->composer('*', function($view) {
      $view->with('currentUser', session()->get('currentUser'));
    });
  }
}