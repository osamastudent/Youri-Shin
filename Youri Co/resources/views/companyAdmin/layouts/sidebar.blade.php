<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="waves-effect waves-dark" href="/company/dashboard" aria-expanded="false">
                        <i class="icon-speedometer"></i><span>Dashboard</span>
                    </a>
                    <hr style="width: 20%; color: #ccc; border-color: #ccc;">
                </li>
                <li class="{{ Request::is('company-customer*') || Request::is('company-zone*') || Request::is('company-vendor*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-panel"></i> <!-- You can replace 'ti-panel' with any other desired icon class -->
                        <span class="hide-menu">Administration</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        
                        <li class="{{ Request::is('company-staff*') ? 'active' : '' }}">
                            <a href="{{ route('company-staff.index') }}"><i class="ti-id-badge"></i> Staff</a>
                        </li>
                        
                        <li class="{{ Request::is('company-zone*') ? 'active' : '' }}">
                            <a href="{{ route('company-zone.index') }}"><i class="ti-location-pin"></i> Zones</a>
                        </li>
                        
                        <li class="{{ Request::is('company-vendor*') ? 'active' : '' }}">
                            <a href="{{ route('company-vendor.index') }}"><i class="ti-truck"></i> Vendor</a>
                        </li>
                        
                        <li class="{{ Request::is('company-customer*') ? 'active' : '' }}">
                            <a href="{{ route('company-customer.index') }}"><i class="ti-user"></i> Customers</a>
                        </li>
                        
                      
                        

                    </ul>
                </li>
                
                  <li class="{{ Request::is('company-item*') ? 'active' : '' }}">
                            <a href="{{ route('company-item.index') }}"><i class="ti-package"></i> Items</a>
                        </li>
                
                <li class="{{ Request::is('company-customer*') || Request::is('company-zone*') || Request::is('company-vendor*') ? 'active' : '' }}">
                 

                    <ul aria-expanded="false" class="collapse">
                      
                        
                  {{--      <li class="{{ Request::is('company-banners*') ? 'active' : '' }}">
                            <a href="{{ route('company-banners.index') }}"><i class="ti-image"></i> Banners</a>
                        </li>  --}}
                    </ul>
                </li>
                
                <li class="">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-wallet"></i> <!-- Icon for Expenses -->
                        <span class="hide-menu">Expenses</span>
                    </a>
                
                    <ul aria-expanded="false" class="collapse">
                        <li class="">
                            <a href="{{ route('company-expense.category-index') }}"><i class="ti-layers-alt"></i>&nbsp;&nbsp; Expense &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category</a> <!-- Icon for Expense Category -->
                        </li>
                        
                         
                        <li class="">
                            <a href="{{ route('company-expense.index') }}"><i class="ti-view-list-alt"></i>&nbsp;&nbsp; Expense List</a> 
                        </li>

                    </ul>
                </li>

<li>
    

  <a href="{{ route('company-sale.index') }}"><i class="ti-list"></i> Order List</a>
  </li>
  
       {{--         <li class="">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-settings"></i> 
                        <span class="hide-menu">Operations</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                         
                            
                                <a href="{{ route('company-sale.index') }}"><i class="ti-list"></i> Order List</a>
                            

                        <!--<li class=""><a href="{{ route('company-zone.index') }}">Sale quotation</a></li>-->
          
                        <!--<li class=""><a href="{{ route('company-item.index') }}">Expense</a></li>-->
                        <!--<li class=""><a href="{{ route('company-sale.index') }}">Purchase</a></li>-->
                        <!--<li class=""><a href="{{ route('company-role.index') }}">Purchase return</a></li>-->
                        <!--<li class=""><a href="{{ route('company-role.index') }}">Payments</a></li>-->
                        <!--<li class=""><a href="{{ route('company-role.index') }}">Production</a></li>-->
                        <!--<li class=""><a href="{{ route('company-role.index') }}">Breakage/ wastage</a></li>-->

                    </ul>
                    
                </li>  --}}
                
                 <li class="">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="ti-shopping-cart"></i> 
                    <span class="hide-menu">Purchase</span>

                    </a>
 
                    <ul aria-expanded="false" class="collapse">
                         
                            <li class="">
                                <a href="{{ route('company-purchase.index') }}"> <i class="ti-shopping-cart"></i> Purchase</a>
                            </li>
                    </ul> 
                     
                </li>
                
          {{--        <li class="">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                      <i class="ti-shopping-cart"></i> 
                    <span class="hide-menu">Vendors</span>

                    </a>
 
                    <ul aria-expanded="false" class="collapse">
                         
                            <li class="">
                                            <li class=""><a href="{{ route('company-vendor.index') }}">Vendors List</a></li>
                            </li>
                    </ul> 
                     
                </li>   --}}
                
                <li class="">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-bar-chart"></i> 
                        <span class="hide-menu">Reports</span>
                    </a>

                    <ul aria-expanded="false" class="collapse">
                        <li class="">
                            <a href="{{ route('company.timeline-reports.index') }}"><i class="ti-time"></i>&nbsp;&nbsp;Order Timeline &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report</a>
                        </li>
                        
                        <li class="">
                            <a href="{{ route('company.due-payment-reports.index') }}">
                                <i class="ti-wallet"></i>&nbsp;&nbsp;Due Payment &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report
                            </a>
                        </li>
                        
                    {{--    <li class="">
                            <a href="{{ route('company.bottles-reports.index') }}">
                                <i class="fa fa-wine-bottle"></i>&nbsp;&nbsp;19L Empty bottles &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report
                            </a>
                        </li> --}}


                    </ul>
                    
                </li>
                
                
                
         {{--       
           <li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fa fa-credit-card-alt mr-2"></i>
        <span class="hide-menu">Subscription </span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li>
            <a href="{{ route('company-subscriptions.data') }}" class="d-flex align-items-center">
                <i class="fa fa-database mr-2 text-primary"></i>
                <span>Subscription Data</span>
            </a>
        </li>
        <li>
            <a href="{{ route('company-subscriptions.list') }}" class="d-flex align-items-center">
                <i class="fa fa-users mr-2 text-success"></i>
                <span>Subscriber Lists</span>
            </a>
            
            
           <a href="{{ route('company-subscriptions.create') }}" class="d-flex align-items-center">
    <i class="fa fa-users mr-2 text-success"></i>
    <span>Subscriber Lists</span>
</a>

        </li>
    </ul>
</li>

                
                
                 <!-- Card Management -->
            <li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fa fa-id-card mr-2"></i>
        <span class="hide-menu">Jal Card</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li>
            <a href="{{ route('jal_cards.index') }}" class="d-flex align-items-center">
                <i class="fa fa-list mr-2 text-primary"></i>
                <span>Jal Card</span>
            </a>
        </li>
    </ul>
</li>

            <!-- Coupon Management -->
            <li>
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-ticket mr-2"></i>
                    <span class="hide-menu">Coupon </span>
                </a>
                <ul aria-expanded="false" class="collapse">
                    <li>
                        <a href="{{ route('coupons.index') }}" class="d-flex align-items-center">
                            <i class="fa fa-list mr-2 text-success"></i>
                            <span>Coupon</span>
                        </a>
                    </li>
                </ul>
            </li>




          <!-- Notification Management -->
            <li>
    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fa fa-ticket mr-2"></i>
        <span class="hide-menu">Notification </span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li>
            <a href="{{ route('notifications.create') }}" class="d-flex align-items-center">
                <i class="fa fa-list mr-2 text-success"></i>
                <span>Notification</span>
            </a>
        </li>
    </ul>
</li>

--}}
           
                
            <!-- Chat Management -->
<li class="{{ Request::is('company/chat*') ? 'active' : '' }}">
    <a href="{{ route('company-chat.index') }}" class="d-flex align-items-center">
        <i class="fa-solid fa-comments mr-2 text-primary"></i>
        <span>Rider Chat</span>
    </a>
</li>

    {{--    <li class="{{ Request::is('customer/chat*') ? 'active' : '' }}">
            <a href="{{ route('customer-chat.index') }}" class="d-flex align-items-center">
                <i class="fa-regular fa-comment-dots mr-2 text-success"></i>
                <span>Customer Chat</span>
            </a>
        </li>  --}}
    

                
                
                <!--<li class="">-->
                <!--    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">-->
                <!--        <i class="ti-user"></i>-->
                <!--        <span class="hide-menu">Finance</span>-->
                <!--    </a>-->
                <!--    <ul aria-expanded="false" class="collapse">-->
                <!--         <li class=""><a href="{{ route('company-purchaseorder.index') }}"> Purchse Order</a></li>-->
                <!--         <li class=""><a href="{{ route('company-account_payable.index') }}"> Account Payable</a></li>-->
                <!--         <li class=""><a href="{{ route('company-account_receivable.index') }}"> Accounts Reciveable</a></li>-->
                <!--         <li class=""><a href="{{ route('company-general_ledger.index') }}"> General Ledger</a></li>-->
                <!--         <li class=""><a href="{{ route('company-expense_tracking.index') }}">Expense Tracking</a></li>-->
                <!--         <li class=""><a href="{{ route('company-budget_forcasting.index') }}">Budget and Forcasting</a></li>-->
                <!--         <li class=""><a href="{{ route('company-inventory_management.index') }}">Inventory Management</a></li>-->
                <!--         <li class=""><a href="{{ route('company-tax_compliance.index') }}">Tax Compliance</a></li>-->
                <!--         <li class=""><a href="{{ route('company-financial_reporting.index') }}">Financial Reporting</a></li>-->
                <!--         <li class=""><a href="{{ route('company-payment_processing.index') }}"> Payment Processing</a></li>-->
                <!--         <li class=""><a href="{{ route('company-financial_reporting.index') }}">Financial Reporting</a></li>-->


                <!--    </ul>-->
                <!--</li>-->
        
            </ul>
        </nav>
    </div>
</aside>

<!-- jQuery library include karen -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Custom script to handle collapse behavior -->
<script>
    $(document).ready(function() {
        $('.has-arrow').on('click', function() {
            var $this = $(this);
            var $submenu = $this.next('.collapse');
            
            // Toggle the current submenu
            $submenu.slideToggle();

            // Set aria-expanded attribute
            var isExpanded = $this.attr('aria-expanded') === 'true';
            $this.attr('aria-expanded', !isExpanded);
        });
    });
</script>
