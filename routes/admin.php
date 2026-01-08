    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Admin\DashboardController;
    use App\Http\Controllers\Admin\DPD\DpdController;
    use App\Http\Controllers\Admin\DPC\DpcController;
    use App\Http\Controllers\Admin\DPRT\DprtController;
    use App\Http\Controllers\Admin\Kader\KaderController;
    use App\Http\Controllers\Admin\Berita\BeritaController;
    use App\Http\Controllers\Admin\Berita\BeritaCategoryController;
    use App\Http\Controllers\Admin\GisController;
    use App\Http\Controllers\Admin\GalleryController;
    use App\Http\Controllers\Admin\ContactMessageController;
    use App\Http\Controllers\Admin\OrganizationStructureController;

    Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

        // Dashboard - hanya untuk yang punya akses
        Route::middleware(['role:super-admin,dpd-admin,dpc-admin,news-writer,kader'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        });

        // DPD Routes - hanya untuk super-admin dan dpd-admin
        Route::middleware(['role:super-admin,dpd-admin'])->prefix('dpd')->name('dpd.')->group(function () {
            Route::get('/', [DpdController::class, 'index'])->name('index');
            Route::get('/create', [DpdController::class, 'create'])->name('create');
            Route::post('/', [DpdController::class, 'store'])->name('store');
            Route::get('/{dpd}', [DpdController::class, 'show'])->name('show');
            Route::get('/{dpd}/edit', [DpdController::class, 'edit'])->name('edit');
            Route::put('/{dpd}', [DpdController::class, 'update'])->name('update');
            Route::delete('/{dpd}', [DpdController::class, 'destroy'])->name('destroy');


            // Structure
            Route::get('/{dpd}/structure', [DpdController::class, 'structure'])->name('structure');
            // TAMBAHKAN INI ↓
            Route::get('/{dpd}/structure/edit', [DpdController::class, 'editStructure'])->name('structure.edit');
            // Structure
            Route::put('/{dpd}/structure-main', [DpdController::class, 'updateStructureMain'])->name('structure.main.update');
            Route::post('/{dpd}/structure', [DpdController::class, 'storeStructure'])->name('structure.store');
            Route::put('/{dpd}/structure/{structure}', [DpdController::class, 'updateStructure'])->name('structure.update');
            Route::delete('/{dpd}/structure/{structure}', [DpdController::class, 'destroyStructure'])->name('structure.destroy');
        });

        // DPC Routes - untuk super-admin, dpd-admin, dpc-admin
        Route::middleware(['role:super-admin,dpd-admin,dpc-admin'])->prefix('dpc')->name('dpc.')->group(function () {
            Route::get('/', [DpcController::class, 'index'])->name('index');
            Route::get('/create', [DpcController::class, 'create'])->name('create');
            Route::post('/', [DpcController::class, 'store'])->name('store');
            Route::get('/{dpc}', [DpcController::class, 'show'])->name('show');
            Route::get('/{dpc}/edit', [DpcController::class, 'edit'])->name('edit');
            Route::put('/{dpc}', [DpcController::class, 'update'])->name('update');
            Route::delete('/{dpc}', [DpcController::class, 'destroy'])->name('destroy');


            Route::patch('/{dpc}/toggle-status', [DpcController::class, 'toggleStatus'])->name('toggle-status');
            // Structure
            Route::get('/{dpc}/structure', [DpcController::class, 'structure'])->name('structure');
            Route::get('/{dpc}/structure/edit', [DpcController::class, 'editStructure'])->name('structure.edit'); // ← TAMBAHKAN INI
            Route::post('/{dpc}/structure', [DpcController::class, 'storeStructure'])->name('structure.store'); // ← TAMBAHKAN INI
            Route::put('/{dpc}/structure/{structure}', [DpcController::class, 'updateStructure'])->name('structure.update'); // ← TAMBAHKAN INI
            Route::delete('/{dpc}/structure/{structure}', [DpcController::class, 'destroyStructure'])->name('structure.destroy'); // ← TAMBAHKAN INI

            // API for modal
            Route::get('/{dpc}/data', [DpcController::class, 'data'])->name('data');
        });

        // Organization Structure Routes - untuk semua admin
        Route::middleware(['role:super-admin,dpd-admin,dpc-admin'])->prefix('organization-structures')->name('organization-structures.')->group(function () {
            Route::get('/', [OrganizationStructureController::class, 'index'])->name('index');
            Route::get('/select-organization', [OrganizationStructureController::class, 'selectOrganization'])->name('select-organization');
            Route::get('/create', [OrganizationStructureController::class, 'create'])
                ->name('create')
                ->where('organization_type', 'dpd|dpc|dprt'); // Validasi parameter
            Route::post('/', [OrganizationStructureController::class, 'store'])->name('store');
            Route::get('/{organizationStructure}', [OrganizationStructureController::class, 'show'])->name('show');
            Route::get('/{organizationStructure}/edit', [OrganizationStructureController::class, 'edit'])->name('edit');
            Route::put('/{organizationStructure}', [OrganizationStructureController::class, 'update'])->name('update');
            Route::delete('/{organizationStructure}', [OrganizationStructureController::class, 'destroy'])->name('destroy');
            Route::patch('/{organizationStructure}/toggle-active', [OrganizationStructureController::class, 'toggleActive'])->name('toggle-active');
        });
        // DPRT Routes - untuk super-admin, dpd-admin, dpc-admin
        Route::middleware(['role:super-admin,dpd-admin,dpc-admin'])->prefix('dprt')->name('dprt.')->group(function () {
            Route::get('/', [DprtController::class, 'index'])->name('index');
            Route::get('/create', [DprtController::class, 'create'])->name('create');
            Route::post('/', [DprtController::class, 'store'])->name('store');
            Route::get('/{dprt}', [DprtController::class, 'show'])->name('show');
            Route::get('/{dprt}/edit', [DprtController::class, 'edit'])->name('edit');
            Route::put('/{dprt}', [DprtController::class, 'update'])->name('update');
            Route::delete('/{dprt}', [DprtController::class, 'destroy'])->name('destroy');
            Route::patch('/{dprt}/restore', [DprtController::class, 'restore'])->name('restore');

            // API for modal
            Route::get('/{dprt}/data', [DprtController::class, 'data'])->name('data');

            Route::patch('/{dprt}/toggle-status', [DprtController::class, 'toggleStatus'])->name('toggle-status');
            // Structure routes - TAMBAHKAN INI
            Route::get('/{dprt}/structure', [DprtController::class, 'structure'])->name('structure.index');
            Route::get('/{dprt}/structure/create', [DprtController::class, 'structureCreate'])->name('structure.create');
            Route::post('/{dprt}/structure', [DprtController::class, 'structureStore'])->name('structure.store');
            Route::get('/{dprt}/structure/{structure}/edit', [DprtController::class, 'structureEdit'])->name('structure.edit');
            Route::put('/{dprt}/structure/{structure}', [DprtController::class, 'structureUpdate'])->name('structure.update');
            Route::delete('/{dprt}/structure/{structure}', [DprtController::class, 'structureDestroy'])->name('structure.destroy');
            Route::get('/{dprt}/structure/export', [DprtController::class, 'structureExport'])->name('structure.export');
        });

        // Kader Routes - untuk super-admin, dpd-admin, dpc-admin
        Route::middleware(['role:super-admin,dpd-admin,dpc-admin'])->prefix('kader')->name('kader.')->group(function () {
            Route::get('/', [KaderController::class, 'index'])->name('index');
            Route::get('/create', [KaderController::class, 'create'])->name('create');
            Route::post('/', [KaderController::class, 'store'])->name('store');
            Route::get('/{kader}', [KaderController::class, 'show'])->name('show');
            Route::get('/{kader}/edit', [KaderController::class, 'edit'])->name('edit');
            Route::put('/{kader}', [KaderController::class, 'update'])->name('update');
            Route::delete('/{kader}', [KaderController::class, 'destroy'])->name('destroy');
            Route::patch('/{kader}/verify', [KaderController::class, 'verify'])->name('verify'); // perubahan metod post menjadi patch
            Route::get('/kader/{kader}/print-card', [KaderController::class, 'printCard'])->name('kader.print-card');
            Route::get('/{kader}/print-card', [KaderController::class, 'printCard'])->name('print-card');
            Route::get('/{kader}/data', [KaderController::class, 'getData'])->name('data');
            Route::patch('/{kader}/toggle-verification', [KaderController::class, 'toggleVerification'])->name('toggle-verification');
            Route::patch('/{kader}/toggle-active', [KaderController::class, 'toggleActive'])->name('toggle-active');
            Route::patch('/{kader}/restore', [KaderController::class, 'restore'])->name('restore');
            Route::get('/export', [KaderController::class, 'export'])->name('export');
        });

        // Berita Routes - untuk super-admin, dpd-admin, news-writer
        Route::middleware(['role:super-admin,dpd-admin,news-writer'])->prefix('berita')->name('berita.')->group(function () {
            Route::get('/', [BeritaController::class, 'index'])->name('index');
            Route::get('/create', [BeritaController::class, 'create'])->name('create');
            Route::post('/', [BeritaController::class, 'store'])->name('store');
            Route::get('/{berita}', [BeritaController::class, 'show'])->name('show');
            Route::get('/{berita}/edit', [BeritaController::class, 'edit'])->name('edit');
            Route::put('/{berita}', [BeritaController::class, 'update'])->name('update');
            Route::delete('/{berita}', [BeritaController::class, 'destroy'])->name('destroy');
            Route::post('/{berita}/publish', [BeritaController::class, 'publish'])->name('publish');
        });

        Route::middleware(['role:super-admin,dpd-admin'])->prefix('berita/categories')->name('berita.categories.')->group(function () {
            Route::get('/', [BeritaCategoryController::class, 'index'])->name('index');
            Route::get('/create', [BeritaCategoryController::class, 'create'])->name('create');
            Route::post('/', [BeritaCategoryController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [BeritaCategoryController::class, 'edit'])->name('edit');
            Route::put('/{category}', [BeritaCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [BeritaCategoryController::class, 'destroy'])->name('destroy');
        });

        // Gallery Routes - untuk super-admin, dpd-admin, news-writer
        Route::middleware(['role:super-admin,dpd-admin,news-writer'])->prefix('galleries')->name('galleries.')->group(function () {
            Route::get('/', [GalleryController::class, 'index'])->name('index');
            Route::get('/create', [GalleryController::class, 'create'])->name('create');
            Route::post('/', [GalleryController::class, 'store'])->name('store');
            Route::get('/{gallery}', [GalleryController::class, 'show'])->name('show');
            Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('edit');
            Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
            Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
            Route::post('/{gallery}/reorder', [GalleryController::class, 'reorderImages'])->name('reorder');
            Route::post('/{gallery}/toggle-publish', [GalleryController::class, 'togglePublish'])->name('toggle-publish');
            Route::delete('/gallery-images/{image}', [GalleryController::class, 'deleteImage'])->name('gallery-images.destroy');
        });

        // GIS Routes - untuk super-admin dan dpd-admin
        Route::middleware(['role:super-admin,dpd-admin'])->prefix('gis')->name('gis.')->group(function () {
            Route::get('/', [GisController::class, 'index'])->name('index');
            Route::get('/map', [GisController::class, 'map'])->name('map');
            Route::post('/upload', [GisController::class, 'upload'])->name('upload');
            Route::get('/api/data', [GisController::class, 'apiData'])->name('api.data');
            Route::get('/api/geojson/{type}/{id?}', [GisController::class, 'getGeojson'])->name('api.geojson');
            Route::get('/api/statistics', [GisController::class, 'getStatistics'])->name('api.statistics');
        });


        Route::middleware(['role:super-admin,dpd-admin'])->prefix('contact-messages')->name('contact-messages.')->group(function () {
            Route::get('/', [ContactMessageController::class, 'index'])->name('index');
            Route::get('/{message}', [ContactMessageController::class, 'show'])->name('show');
            Route::post('/{message}/reply', [ContactMessageController::class, 'reply'])->name('reply');
            Route::post('/{message}/mark-as-read', [ContactMessageController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/{message}/mark-as-archived', [ContactMessageController::class, 'markAsArchived'])->name('mark-as-archived');
            Route::delete('/{message}', [ContactMessageController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-action', [ContactMessageController::class, 'bulkAction'])->name('bulk-action');
            Route::get('/api/stats', [ContactMessageController::class, 'getStats'])->name('api.stats');
        });
    });
