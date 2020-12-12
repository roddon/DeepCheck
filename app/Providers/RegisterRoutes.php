<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

class RegisterRoutes
{

    protected $namespace = 'App\Http\Controllers';

    public function bind(Application $app)
    {
        // Web Routes
        $this->mapWebRoutes();

        //Dashboard Routes
        $this->mapDashboardRoutes();

        //Dashboard Routes
        $this->mapAuthRoutes();

        // Users Routes
        $this->mapUserRoutes();

        // Setting Routes
        $this->mapSettingRoutes();

        // Company Routes
        $this->mapCompanyRoutes();

        // API Routes
        $this->mapApiRoutes();

        //Auth API routes
        $this->mapApiAuthRoutes();

        //Company API routes
        $this->mapApiCompanyRoutes();
        // Onboarding Routes
        $this->mapOnboardingRoutes();
        $this->mapInvoiceRoutes();

        $this->mapLiveProtectRoutes();


        $this->mapsVaultRoutes();

        $this->mapsEmailRoutes();

        $this->mapsDetectorRoutes();

        $this->mapEnterpriseRoutes();

        $this->mapsAdminRoutes();

        $this->mapsActivityLogRoutes();

        $this->mapsVerificationRoutes();

        $this->mapApiOnboardingRoutes();
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }


    /**
     * Define the "auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::prefix('auth')
            ->middleware(['web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/auth.php'));
    }

    /**
     * Define the "auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::prefix('users')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/users.php'));
    }


    /**
     * Define the "company" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapSettingRoutes()
    {
        Route::prefix('settings')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/settings.php'));
    }


    /**
     * Define the "company" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCompanyRoutes()
    {
        Route::prefix('company')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/company.php'));
    }


    /**
     * Define the "auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDashboardRoutes()
    {
        Route::prefix('dashboard')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/dashboard.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "api/auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiAuthRoutes()
    {
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/api/auth.php'));
    }


    /**
     * Define the "api/auth" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiCompanyRoutes()
    {
        Route::prefix('api/company')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/api/company.php'));
    }

    protected function mapOnboardingRoutes()
    {
        Route::prefix('onboarding')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/onboarding.php'));
    }

    protected function mapInvoiceRoutes()
    {
        Route::middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/invoice.php'));
    }

    /**
     * Define the "liveProtect" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapLiveProtectRoutes()
    {
        Route::prefix('live-protect')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/liveProtect.php'));
    }


    protected function mapsVaultRoutes()
    {
        Route::prefix('s-vault')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/sVault.php'));
    }

    protected function mapEnterpriseRoutes()
    {
        Route::prefix('enterprise')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/enterprise.php'));
    }

    protected function mapsEmailRoutes()
    {
        Route::middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/email.php'));
    }

    protected function mapsDetectorRoutes()
    {
        Route::prefix('detector')
            ->middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/detector.php'));
    }


    protected function mapsAdminRoutes()
    {
        Route::prefix('admin')
            ->as('admin.')
            ->middleware(['web', 'adminAuth'])
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/assets/admin.php'));
    }

    protected function mapsActivityLogRoutes()
    {
        Route::middleware(['web', 'userAuth'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/activityLog.php'));
    }


    protected function mapsVerificationRoutes()
    {
        Route::prefix('verification')
            ->as('verification.')
            ->middleware(['web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/verification.php'));
    }

    protected function mapApiOnboardingRoutes()
    {
        Route::prefix('api/onboarding')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/assets/api/onboarding.php'));
    }
}
