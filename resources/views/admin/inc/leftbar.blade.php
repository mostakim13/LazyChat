 <!-- ########## START: LEFT PANEL ########## -->
 <div class="sl-logo"><a href="{{ route('admin.dashboard') }}"><i class="icon ion-android-star-outline"></i>
         LazyChat</a></div>
 <div class="sl-sideleft">
     <div class="sl-sideleft-menu">

         <a href="{{ route('admin.dashboard') }}" class="sl-menu-link">
             <div class="sl-menu-item">
                 <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                 <span class="menu-item-label">Dashboard</span>
             </div><!-- menu-item -->
         </a><!-- sl-menu-link -->

         <a href="#" class="sl-menu-link @yield('products')">
             <div class="sl-menu-item">
                 <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
                 <span class="menu-item-label">Products</span>
                 <i class="menu-item-arrow fa fa-angle-down"></i>
             </div><!-- menu-item -->
         </a><!-- sl-menu-link -->
         <ul class="sl-menu-sub nav flex-column">
             <li class="nav-item"><a href="{{ route('add-product') }}"
                     class="nav-link @yield('add-product')">Add Product</a></li>
             <li class="nav-item"><a href="{{ route('manage-product') }}"
                     class="nav-link @yield('manage-product')">Manage Product</a></li>
         </ul>

     </div><!-- sl-sideleft-menu -->

     <br>
 </div><!-- sl-sideleft -->
 <!-- ########## END: LEFT PANEL ########## -->
