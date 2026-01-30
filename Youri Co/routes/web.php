<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontPackagesController;

// SUPER ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubscriptionManagementController;
use App\Http\Controllers\Admin\GuideController;



// COMPANY ADMIN
use App\Http\Controllers\companyAdmin\ZoneController;
use App\Http\Controllers\companyAdmin\CustomerController;
use App\Http\Controllers\companyAdmin\VendorController;
use App\Http\Controllers\companyAdmin\ItemsController;                                          
use App\Http\Controllers\companyAdmin\SalesController;
use App\Http\Controllers\companyAdmin\PurchaseController;
use App\Http\Controllers\companyAdmin\RoleController;       
use App\Http\Controllers\companyAdmin\SaleListController;
use App\Http\Controllers\companyAdmin\StaffController;
use App\Http\Controllers\companyAdmin\PurchaseOrderController;
use App\Http\Controllers\companyAdmin\AccountPayableController;
use App\Http\Controllers\companyAdmin\ProfileController;
use App\Http\Controllers\companyAdmin\AccountReceivableController;
use App\Http\Controllers\companyAdmin\GeneralLedgerController;
use App\Http\Controllers\companyAdmin\ExpenseTrackingController;
use App\Http\Controllers\companyAdmin\BudgetingForcastingController;
use App\Http\Controllers\companyAdmin\InventoryManagementController;
use App\Http\Controllers\companyAdmin\TaxComplianceController;
use App\Http\Controllers\companyAdmin\FinancialReportingController;
use App\Http\Controllers\companyAdmin\PaymentProcessingController;
use App\Http\Controllers\companyAdmin\BannersController;
use App\Http\Controllers\companyAdmin\ExpenseController; 
use App\Http\Controllers\companyAdmin\ChatController;
use App\Http\Controllers\companyAdmin\CustomerChatController;
use App\Http\Controllers\companyAdmin\JalCardController;
use App\Http\Controllers\companyAdmin\CouponController;
use App\Http\Controllers\companyAdmin\CompanySubscriptionManagementController;
use App\Http\Controllers\companyAdmin\NotificationController;
use App\Http\Controllers\companyAdmin\SubscriptionController;


use App\Http\Controllers\Admin\DeactivateUserController;
use App\Http\Controllers\API\ApiController;
// REPORTS
use App\Http\Controllers\companyAdmin\Reports\TimelineReportController;
use App\Http\Controllers\companyAdmin\Reports\DuePaymentController;
use App\Http\Controllers\companyAdmin\Reports\BottlesController; 
use App\Http\Controllers\companyAdmin\DashboardCompanyController; 



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    $package = App\Models\Package::all();
    return view('index', compact('package'));
});


// Privacy Policy


Route::view('/privacy-policy', 'privacy-policy');


   Route::post('staff/deactivate', [DeactivateUserController::class, 'deactivateStaff'])->name('staff.deactivate.submit');
Route::post('/front-packages', [FrontPackagesController::class, 'store'])->name('front-package.store');



Route::get('/admin', function () {
    return view('auth.login');
});


Route::middleware('auth')->group(function () {
    Route::get('/{id}/profile', [ProfileController::class, 'index'])->name('profile');
});


/*************************************SUPER ADMIN*************************************/

Route::middleware(['auth', 'SuperAdmin'])->group(function () {
    
    Route::get('/dashboard', function () {
        $companyCount = App\Models\USer::where('user_type', 2)->count();
        return view('admin.dashboard', compact('companyCount'));
    });
    
    // In routes/web.php

 
    // COMPANY CRUD
    Route::controller(CompanyController::class)->prefix('company')->name('company.')->group(function () {        
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/show', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}/update', 'update')->name('update');
        Route::get('/{id}/delete', 'delete')->name('delete');
        Route::put('/changeStatus/{id}' , 'changeStatus')->name('changeStatus');

    });
    
    // PACKAGES CRUD
    Route::controller(PackageController::class)->prefix('package')->name('package.')->group(function () {        
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/show', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}/update', 'update')->name('update');
        Route::delete('/{id}/delete', 'delete')->name('delete');
    });
    
    
    
    

    
    
    
    // Subscription Data


      Route::controller(SubscriptionManagementController::class)->prefix('subscriptions')->name('admin.subscriptions.')->group(function () {        
        Route::get('/', 'index')->name('index');

        
        
        
        
        
        
    });
    
    
    // Guide Data
    
      Route::controller(GuideController::class)->prefix('guides')->name('admin.guides.')->group(function () {        
        Route::get('/company/guide', 'index')->name('index');
        Route::get('/staff/guide', 'staff_guide')->name('staff_guide');
        Route::get('/customer/guide', 'customer_guide')->name('customer_guide');
        Route::post('/store', 'store')->name('store');
       


    });
    
 Route::resource('guides', GuideController::class);
});
/*************************************COMPANY ADMIN*************************************/

Route::middleware(['auth', 'CompanyAdmin'])->group(function () {
    Route::get('/company/dashboard', [DashboardCompanyController::class, 'index'])->name('company.dashboard');
});


###########Zones###########
Route::controller(ZoneController::class)->prefix('company/zone')->name('company-zone.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});


###########Customers###########
Route::controller(CustomerController::class)->prefix('company/customer')->name('company-customer.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::put('/updateStatus/{id}' , 'updateStatus')->name('updateStatus');

});
###########Vendor###########
Route::controller(VendorController::class)->prefix('company/vendor')->name('company-vendor.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});

###########Items###########
Route::controller(ItemsController::class)->prefix('company/item')->name('company-item.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
###########Sale###########
Route::controller(SalesController::class)->prefix('company/sale')->name('company-sale.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/status', 'statusChange')->name('statusChange');
    

    Route::post('/{id}/update', 'update')->name('update');
    Route::patch('/{id}/update-status', 'updateStatus')->name('update-status');
    Route::get('/orders', 'getLatestOrders')->name('orders');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::get('/{id}/print', 'printInvoice')->name('print'); 
    
    
    
 
});

// QR Code Routes
Route::get('/company/sale/{id}/qrcode', [SalesController::class, 'showQRCode'])->name('sale.qrcode.view');
Route::get('/company/sale/{id}/download-qrcode', [SalesController::class, 'downloadQRCode'])->name('sale.qrcode.download');

###########Purchase###########
Route::controller(PurchaseController::class)->prefix('company/purchase')->name('company-purchase.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    
    
});



###########Chat###########
Route::controller(ChatController::class)->prefix('company/chat')->name('company-chat.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('{id}', 'chat')->name('show');
    Route::get('/loadmore', 'chat')->name('loadmore');
    Route::post('/send', 'sendMessage')->name('send');

});

###########Customer Chat###########
Route::controller(CustomerChatController::class)->prefix('customer/chat')->name('customer-chat.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('{id}', 'chat')->name('show');
    // Route::get('/loadmore', 'chat')->name('loadmore');
    Route::post('/send', 'sendMessage')->name('send');

});


###########Role###########
Route::controller(RoleController::class)->prefix('company/role')->name('company-role.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
###########Staff###########
Route::controller(StaffController::class)->prefix('company/staff')->name('company-staff.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});


###########Banners ###########
Route::controller(BannersController::class)->prefix('company/banners')->name('company-banners.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::put('/statusUpdate/{id}' , 'statusUpdate')->name('statusUpdate'); 

});

###########EXPENSE ###########
Route::controller(ExpenseController::class)->prefix('company/expense')->name('company-expense.')->group(function () {     
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store'); 
    Route::get('/{id}/show', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::get('category', 'categoryIndex')->name('category-index');
    Route::get('category/create', 'categoryCreate')->name('category-create');
    Route::post('category/store', 'categoryStore')->name('category-store');
    Route::get('category/{id}/edit', 'categoryEdit')->name('category-edit');
    Route::post('category/{id}/update', 'categoryUpdate')->name('category-update');
    Route::get('category/{id}/delete', 'categoryDelete')->name('category-delete');
    
});




/*************************************COMPANY OPERATIONS*************************************/

###########Sale ###########
Route::controller(SaleListController::class)->prefix('company/salelist')->name('company-salelist.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});



/*************************************SUBSCRIPTION OPERATIONS*************************************/


  Route::controller(CompanySubscriptionManagementController::class)->prefix('company/subscriptions')->name('company-subscriptions.')->group(function () {        
        Route::get('/subscription', 'index')->name('company.index');
        Route::post('/toggle/{id}', 'ajaxToggle')->name('ajaxToggle');
        Route::get('/subscription-data', [CompanySubscriptionManagementController::class, 'SubscriptionData'])->name('data');
        Route::post('/toggle/{id}', [CompanySubscriptionManagementController::class, 'toggleStatus'])->name('toggle');
        Route::get('/list', [CompanySubscriptionManagementController::class, 'subscriptionList'])->name('list');
        
        Route::get('/create', [CompanySubscriptionManagementController::class, 'create'])->name('create');
                Route::post('/store', [CompanySubscriptionManagementController::class, 'store'])->name('store');



    });

/*************************************JAL CARD*************************************/


   
    Route::controller(JalCardController::class)->group(function () {
        Route::get('jal_cards/gencode', 'generateCode');
        Route::post('jal_cards/recharge/{id}', 'recharge')->name('jal_cards.recharge');
        Route::post('jal_cards/deletebyselection', 'deleteBySelection');
    });
    Route::resource('jal_cards', JalCardController::class);



/*************************************COUPON*************************************/




Route::controller(CouponController::class)->group(function () {
        Route::get('coupons/gencode', 'generateCode');
        Route::post('coupons/deletebyselection', 'deleteBySelection');
    });
    Route::resource('coupons', CouponController::class);

// simple GET route
Route::get('coupons/gencode', [CouponController::class, 'generateCode'])
    ->name('coupons.gencode');



/*************************************COUPON*************************************/


// Notification Management (Company → Customers)

    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');




/*************************************REPORTS*************************************/


// TIMELINE
Route::controller(TimelineReportController::class)->prefix('company/timeline-reports')->name('company.timeline-reports.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/fetch-order/', 'fetchOrder')->name('order');
});


// DUE PAYMENTS
Route::controller(DuePaymentController::class)->prefix('company/due-payment-reports')->name('company.due-payment-reports.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/fetch-payment/', 'fetchPayment')->name('payment');
});


// WATER BOTTLES
Route::controller(BottlesController::class)->prefix('company/bottles-reports')->name('company.bottles-reports.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/fetch-bottles/', 'fetchBottles')->name('bottles');
});

//Deactivate User Route

// Route::middleware(['Deactivate'])->group(function() {
    // Route for showing the deactivation form
    Route::get('admin/deactivate', [DeactivateUserController::class, 'index'])->name('admin.deactivate');
    
      Route::get('staff/deactivate', [DeactivateUserController::class, 'staff'])->name('staff.deactivate');
      
   
    // Route for handling the deactivation form submission
    Route::post('admin/deactivate', [DeactivateUserController::class, 'deactivateUser'])->name('admin.deactivate.submit');
// });

Route::get('/check/{staffId}', [ApiController::class, 'get_saleByStaffID']);











Route::resource('subscriptions', SubscriptionController::class);






/*************************************ARCHIVED*************************************/




/*************************************COMPANY FINANCE*************************************/
###########Purchase Order ###########
Route::controller(PurchaseOrderController::class)->prefix('company/purchaseorder')->name('company-purchaseorder.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
###########Account Payable ###########
Route::controller(AccountPayableController::class)->prefix('company/account_payable')->name('company-account_payable.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
###########Account Payable ###########
Route::controller(AccountReceivableController::class)->prefix('company/account_receivable')->name('company-account_receivable.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
########### GERENRAL LEDGER#############################
Route::controller(GeneralLedgerController::class)->prefix('company/general_ledger')->name('company-general_ledger.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
########### Expense Tracking#############################
Route::controller(ExpenseTrackingController::class)->prefix('company/expense_tracking')->name('company-expense_tracking.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
########### Budgeting and Forcasting#############################
Route::controller(BudgetingForcastingController::class)->prefix('company/budget_forcasting')->name('company-budget_forcasting.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
########### Inventory Management#############################
Route::controller(InventoryManagementController::class)->prefix('company/inventory_management')->name('company-inventory_management.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
########### ######## TaxCompliance#############################
Route::controller(TaxComplianceController::class)->prefix('company/tax_compliance')->name('company-tax_compliance.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
##################### Financial Reporting#############################
Route::controller(FinancialReportingController::class)->prefix('company/financial_reporting')->name('company-financial_reporting.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});
###########Payment Processing ###########
Route::controller(PaymentProcessingController::class)->prefix('company/payment_processing')->name('company-payment_processing.')->group(function () {        
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::post('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
});


/*************************************ARCHIVED*************************************/






Route::post('/company-customer/import',[CustomerController::class, 'import'])->name('company-customer.import');



Route::get('/company/sale/{id}/invoice', [SalesController::class, 'showInvoice'])->name('sale.invoice');

// Direct print route
Route::get('/company/sale/{id}/print', [SalesController::class, 'printInvoice'])->name('sale.print');


Route::get('/sales/invoice/{id}/download', [SalesController::class, 'downloadInvoice'])
     ->name('sales.invoice.download');


require __DIR__.'/auth.php';
