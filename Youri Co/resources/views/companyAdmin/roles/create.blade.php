@extends('companyAdmin.layouts.master')

@section('page-title')
    Sales
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form name="formCreate" id="formCreate" method="POST" action="{{ route('company-sale.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <h3 class="card-title">Role Info</h3>
                            <hr>
                            <div class="row p-t-20">
                                <!-- Date Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Role Name</label>
                                        <input type="text" name="role_name" id="date" class="form-control">
                                        @error('role_name')
                                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>



                             <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Data Access Type</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input type="radio" name="data_access_type" id="whole_data" value="whole_data" class="form-check-input" onchange="togglePaymentFields()">
                                        <label class="form-check-label" for="whole_data">Whole Data</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input type="radio" name="data_access_type" id="only_assigned_zone_data" value="only_assigned_zone_data" class="form-check-input" onchange="togglePaymentFields()">
                                        <label class="form-check-label" for="only_assigned_zone_data">Only Assigned Zone Data</label>
                                    </div>
                                </div>
                                @error('payment')
                                    <small class="form-control-feedback text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                                

                             <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Management</label>
                            <div class="d-flex flex-wrap">
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="view_dashboard" value="view_dashboard" class="form-check-input">
                                    <label class="form-check-label" for="view_dashboard">View Dashboard</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="deactivate_customer" value="deactivate_customer" class="form-check-input">
                                    <label class="form-check-label" for="deactivate_customer">Deactivate Customer</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_customers" value="manage_customers" class="form-check-input">
                                    <label class="form-check-label" for="manage_customers">Manage Customers</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="activate_staff" value="activate_staff" class="form-check-input">
                                    <label class="form-check-label" for="activate_staff">Activate Staff</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_vendors" value="manage_vendors" class="form-check-input">
                                    <label class="form-check-label" for="manage_vendors">Manage Vendors</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="make_changes_entries" value="make_changes_entries" class="form-check-input">
                                    <label class="form-check-label" for="make_changes_entries">Make Changes in Entries</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="make_changes_zones" value="make_changes_zones" class="form-check-input">
                                    <label class="form-check-label" for="make_changes_zones">Make Changes in Zones</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="set_zone_customer" value="set_zone_customer" class="form-check-input">
                                    <label class="form-check-label" for="set_zone_customer">Set Zone of Customer</label>
                                </div> 
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="set_zone_user" value="set_zone_user" class="form-check-input">
                                    <label class="form-check-label" for="set_zone_user">Set Zone of User</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="view_trackboard" value="view_trackboard" class="form-check-input">
                                    <label class="form-check-label" for="view_trackboard">View Trackboard</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_roles" value="manage_roles" class="form-check-input">
                                    <label class="form-check-label" for="manage_roles">Manage Roles</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="manage_inventory" value="manage_inventory" class="form-check-input">
                                    <label class="form-check-label" for="manage_inventory">Manage Inventory</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_users" value="manage_users" class="form-check-input">
                                    <label class="form-check-label" for="manage_users">Manage Users</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="set_location_customer" value="set_location_customer" class="form-check-input">
                                    <label class="form-check-label" for="set_location_customer">Set Location of Customer</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="import_csv_data" value="import_csv_data" class="form-check-input">
                                    <label class="form-check-label" for="import_csv_data">Import Data from CSV</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="assign_day_zones" value="assign_day_zones" class="form-check-input">
                                    <label class="form-check-label" for="assign_day_zones">Assign Day-wise Zones to User</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="set_discount_item" value="set_discount_item" class="form-check-input">
                                    <label class="form-check-label" for="set_discount_item">Set Discount in Item in Master Data</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="set_gst_item" value="set_gst_item" class="form-check-input">
                                    <label class="form-check-label" for="set_gst_item">Set GST in Item in Master Data</label>
                                </div>
                                <div class="form-check me-3 mx-3 ">
                                    <input type="checkbox" name="management_options[]" id="manage_item_stock" value="manage_item_stock" class="form-check-input">
                                    <label class="form-check-label" for="manage_item_stock">Manage Item in Opening Stock</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_expense_heads" value="manage_expense_heads" class="form-check-input">
                                    <label class="form-check-label" for="manage_expense_heads">Manage Expense Heads</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_cash_bank_heads" value="manage_cash_bank_heads" class="form-check-input">
                                    <label class="form-check-label" for="manage_cash_bank_heads">Manage Cash and Bank Heads</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="change_password" value="change_password" class="form-check-input">
                                    <label class="form-check-label" for="change_password">Change Password</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="change_user_password" value="change_user_password" class="form-check-input">
                                    <label class="form-check-label" for="change_user_password">Change User Password</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="change_username" value="change_username" class="form-check-input">
                                    <label class="form-check-label" for="change_username">Change Username</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="set_item_detail" value="set_item_detail" class="form-check-input">
                                    <label class="form-check-label" for="set_item_detail">Set Item Detail</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="change_item_type" value="change_item_type" class="form-check-input">
                                    <label class="form-check-label" for="change_item_type">Change Item Type</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="create_non_disposable_item" value="create_non_disposable_item" class="form-check-input">
                                    <label class="form-check-label" for="create_non_disposable_item">Create Non-Disposable Item</label>
                                </div>
                                <div class="form-check me-3">
                                    <input type="checkbox" name="management_options[]" id="set_barcode_no_item" value="set_barcode_no_item" class="form-check-input">
                                    <label class="form-check-label" for="set_barcode_no_item">Set Barcode No for Item</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="change_invoice_print_page" value="change_invoice_print_page" class="form-check-input">
                                    <label class="form-check-label" for="change_invoice_print_page">Change Invoice Print Page</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="view_verified_no_sale_visits" value="view_verified_no_sale_visits" class="form-check-input">
                                    <label class="form-check-label" for="view_verified_no_sale_visits">View Verified No-Sale Customer Visits</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="change_report_configurations" value="change_report_configurations" class="form-check-input">
                                    <label class="form-check-label" for="change_report_configurations">Change Report Configurations</label>
                                </div>
                                <div class="form-check me-3 mx-3">
                                    <input type="checkbox" name="management_options[]" id="manage_chart_of_account" value="manage_chart_of_account" class="form-check-input">
                                    <label class="form-check-label" for="manage_chart_of_account">Manage Chart of Account</label>
                                </div>
                    </div>
                    @error('payment')
                        <small class="form-control-feedback text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
                             <div class="col-md-7">
                    <div class="form-group">
                        <label class="control-label">Operations</label>
                        <div class="d-flex flex-wrap">
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_sale" value="add_new_sale" class="form-check-input">
                                <label class="form-check-label" for="add_new_sale">Add new Sale</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="add_new_sale_order" value="add_new_sale_order" class="form-check-input">
                                <label class="form-check-label" for="add_new_sale_order">Add new Sale Order</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_collection_entry" value="add_new_collection_entry" class="form-check-input">
                                <label class="form-check-label" for="add_new_collection_entry">Add new Collection Entry</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="add_no_sale_customer_entry" value="add_no_sale_customer_entry" class="form-check-input">
                                <label class="form-check-label" for="add_no_sale_customer_entry">Add no Sale Customer Entry</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_no_sale_customer_visits" value="add_no_sale_customer_visits" class="form-check-input">
                                <label class="form-check-label" for="add_no_sale_customer_visits">Add no Sale Customer Visits</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="change_date" value="change_date" class="form-check-input">
                                <label class="form-check-label" for="change_date">Change Date</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_user" value="change_user" class="form-check-input">
                                <label class="form-check-label" for="change_user">Change User</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="view_stock_customer" value="view_stock_customer" class="form-check-input">
                                <label class="form-check-label" for="view_stock_customer">View stock at Customer</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="view_balance_customer" value="view_balance_customer" class="form-check-input">
                                <label class="form-check-label" for="view_balance_customer">View Balance of Customer</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_financial_voucher" value="add_new_financial_voucher" class="form-check-input">
                                <label class="form-check-label" for="add_new_financial_voucher">Add new Financial Voucher</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_purchase" value="add_new_purchase" class="form-check-input">
                                <label class="form-check-label" for="add_new_purchase">Add new Purchase</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_expense" value="add_new_expense" class="form-check-input">
                                <label class="form-check-label" for="add_new_expense">Add new Expense</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_sale_return" value="add_sale_return" class="form-check-input">
                                <label class="form-check-label" for="add_sale_return">Add Sale Return</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_item_price_document" value="change_item_price_document" class="form-check-input">
                                <label class="form-check-label" for="change_item_price_document">Change item price in Document</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="use_mobile_app" value="use_mobile_app" class="form-check-input">
                                <label class="form-check-label" for="use_mobile_app">Use Mobile App</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_purchase_return" value="add_purchase_return" class="form-check-input">
                                <label class="form-check-label" for="add_purchase_return">Add Purchase Return</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="view_customer_last_values" value="view_customer_last_values" class="form-check-input">
                                <label class="form-check-label" for="view_customer_last_values">View LAST values of Customer</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_production" value="add_production" class="form-check-input">
                                <label class="form-check-label" for="add_production">Add Production</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_discount_document" value="add_discount_document" class="form-check-input">
                                <label class="form-check-label" for="add_discount_document">Add Discount in Document</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_payment_to_vendor" value="add_payment_to_vendor" class="form-check-input">
                                <label class="form-check-label" for="add_payment_to_vendor">Add Payment To Vendor</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_breakage_wastage" value="add_breakage_wastage" class="form-check-input">
                                <label class="form-check-label" for="add_breakage_wastage">Add Breakage/Wastage</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="view_vendor_balance" value="view_vendor_balance" class="form-check-input">
                                <label class="form-check-label" for="view_vendor_balance">View Vendor Balance</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="take_customer_signature" value="take_customer_signature" class="form-check-input">
                                <label class="form-check-label" for="take_customer_signature">Take Customer Signature</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_sale" value="attach_expense_sale" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_sale">Attach Expense with Sale</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="print_sale_invoice" value="print_sale_invoice" class="form-check-input">
                                <label class="form-check-label" for="print_sale_invoice">Print Sale Invoice</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_item_discount_document" value="change_item_discount_document" class="form-check-input">
                                <label class="form-check-label" for="change_item_discount_document">Change Item Discount in Document</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_item_gst_document" value="change_item_gst_document" class="form-check-input">
                                <label class="form-check-label" for="change_item_gst_document">Change Item GST in Document</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="record_gps_data" value="record_gps_data" class="form-check-input">
                                <label class="form-check-label" for="record_gps_data">Record GPS movement data</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_sale_return" value="attach_expense_sale_return" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_sale_return">Attach Expense with Sale Return</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_withholding_tax" value="add_withholding_tax" class="form-check-input">
                                <label class="form-check-label" for="add_withholding_tax">Add Withholding Tax</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_debit_note" value="add_debit_note" class="form-check-input">
                                <label class="form-check-label" for="add_debit_note">Add Debit Note</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_credit_note" value="add_credit_note" class="form-check-input">
                                <label class="form-check-label" for="add_credit_note">Add Credit Note</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_purchase" value="attach_expense_purchase" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_purchase">Attach Expense with Purchase</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_purchase_return" value="attach_expense_purchase_return" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_purchase_return">Attach Expense with Purchase Return</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="print_sale_return" value="print_sale_return" class="form-check-input">
                                <label class="form-check-label" for="print_sale_return">Print sale Return</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_sale_order" value="attach_expense_sale_order" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_sale_order">Attach Expense with Sale Order</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="print_sale_order" value="print_sale_order" class="form-check-input">
                                <label class="form-check-label" for="print_sale_order">Print Sale Order</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_sale_order_quantity" value="change_sale_order_quantity" class="form-check-input">
                                <label class="form-check-label" for="change_sale_order_quantity">Change Sale Order Quantity</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="change_sale_order_quantity_2" value="change_sale_order_quantity_2" class="form-check-input">
                                <label class="form-check-label" for="change_sale_order_quantity_2">Change Sale Order Quantity</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="add_new_sale_quotation" value="add_new_sale_quotation" class="form-check-input">
                                <label class="form-check-label" for="add_new_sale_quotation">Add new Sale Quotation</label>
                            </div>
                            <div class="form-check me-3">
                                <input type="checkbox" name="management_options[]" id="print_sale_quotation" value="print_sale_quotation" class="form-check-input">
                                <label class="form-check-label" for="print_sale_quotation">Print Sale Quotation</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="change_sale_quotation_quantity" value="change_sale_quotation_quantity" class="form-check-input">
                                <label class="form-check-label" for="change_sale_quotation_quantity">Change Sale Quoted Quantity</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="print_purchase_invoice" value="print_purchase_invoice" class="form-check-input">
                                <label class="form-check-label" for="print_purchase_invoice">Print Purchase Invoice</label>
                            </div>
                            <div class="form-check me-3 mx-3 ">
                                <input type="checkbox" name="management_options[]" id="attach_expense_production" value="attach_expense_production" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_production">Attach Expense with Production</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="attach_expense_breakage_wastage" value="attach_expense_breakage_wastage" class="form-check-input">
                                <label class="form-check-label" for="attach_expense_breakage_wastage">Attach Expense with Breakage/Wastage</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="print_collection" value="print_collection" class="form-check-input">
                                <label class="form-check-label" for="print_collection">Print Collection</label>
                            </div>
                            <div class="form-check me-3 mx-3">
                                <input type="checkbox" name="management_options[]" id="print_payment" value="print_payment" class="form-check-input">
                                <label class="form-check-label" for="print_payment">Print Payment</label>
                            </div>
                        </div>
                        @error('payment')
                            <small class="form-control-feedback text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

   
                                
                                
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-actions mt-5">
                            <!-- Clear Button -->
                            <button type="button" class="btn btn-secondary" onclick="clearForm()">
                                Clear
                            </button>

                             <!--Post Button   -->
                            <button type="submit" class="btn btn-primary" id="postButton" >
                                Post
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function clearForm() {
    document.getElementById('formCreate').reset();
    // Hide all fields (cash and bank)
    document.getElementById('cashFields').style.display = 'none';
    document.getElementById('bankFields').style.display = 'none';
}

// Function to handle the SweetAlert modal
function showPostAlert() {
    Swal.fire({
        title: 'Post?',
        text: 'Are you sure you want to post?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        showDenyButton: true,
        denyButtonText: 'Yes, Confirm and Print'
    }).then((result) => {
        if (result.isConfirmed) {
            // Perform the post action here
            // For example, submit the form
            document.getElementById('formCreate').submit();
        } else if (result.isDenied) {
            // Perform the post action and print here
            document.getElementById('formCreate').submit();
            printFunction(); // Call the print function here
        }
        // If cancelled, do nothing
    });
}

// Attach event listener to the Post button
document.getElementById('postButton').addEventListener('click', showPostAlert);

// Example print function (modify as needed)
function printFunction() {
    // Logic for printing
    window.print();
}

</script>

<!-- Include Sweet Alert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
