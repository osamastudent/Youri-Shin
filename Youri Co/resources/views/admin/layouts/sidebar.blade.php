@if(Auth::user()->user_type !== 4)
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">--- PERSONAL</li>
                <li> <a class="waves-effect waves-dark" href="/dashboard" aria-expanded="false"><i class="icon-speedometer"></i><span>Dashboard</span></a>
                <hr style="width: 20%; color: #ccc; border-color: #ccc;">
                </li>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <span class="hide-menu">Companies</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('company.create') }}"><i class="fa fa-plus"></i> Add Company</a></li>
                        <li><a href="{{ route('company.index') }}"><i class="fa fa-list"></i> Company's List</a></li>
                    </ul>
                </li>
                
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <span class="hide-menu">Subscription Packages</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('package.create') }}"><i class="fa fa-plus"></i> Add Package</a></li>
                        <li><a href="{{ route('package.index') }}"><i class="fa fa-list"></i> Package List</a></li>
                    </ul>
                </li>
                
                
                
         {{-- 
         <!--<li>-->
                <!--    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">-->
                <!--        <span class="hide-menu">Subscription Management</span>-->
                <!--    </a>-->
                <!--    <ul aria-expanded="false" class="collapse">-->
                <!--        <li><a href="{{ route('admin.subscriptions.data') }}"><i class="fa fa-list"></i> Subscription Data </a></li>-->
                <!--        <li><a href="{{ route('admin.subscriptions.index') }}"><i class="fa fa-list"></i> Subscription Data List</a></li>-->
                <!--        <li><a href="{{ route('admin.subscriptions.list') }}"><i class="fa fa-list"></i> Subscriber Lists</a></li>-->
                        
                <!--    </ul>-->
                
                <!--</li>-->
             --}}   
              

                
                
                 <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <span class="hide-menu">Guide Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('admin.guides.index') }}"><i class="fa fa-list"></i> Company Admin Guide </a></li>
                        <li><a href="{{ route('admin.guides.staff_guide') }}"><i class="fa fa-list"></i> Rider Guide</a></li>
                        <li><a href="{{ route('admin.guides.customer_guide') }}"><i class="fa fa-list"></i> User Guide</a></li>
                        
                    </ul>
                </li>
                
                
            </ul>
        </nav>
    </div>
</aside>
@else 
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">--- PERSONAL</li>
                <li> <a class="waves-effect waves-dark" href={{ route('admin.deactivate') }} aria-expanded="false"><i class="icon-speedometer"></i><span>Deactivate Customers</span></a>
               
                </li>
                
                   <li> <a href="{{ route('staff.deactivate') }}" class="waves-effect waves-dark"  aria-expanded="false"><i class="icon-speedometer"></i><span>Deactivate Staff</span></a>
               
                </li>
                
                
            </ul>
        </nav>
    </div>
</aside>
@endif