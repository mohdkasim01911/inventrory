<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
        href="{{ route('categories.index') }}">
        <i class="menu-icon mdi mdi-tag-outline"></i>
        <span class="menu-title">Category</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index') }}">
        <i class="menu-icon mdi mdi-cube-outline"></i>
        <span class="menu-title">Product</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
        <i class="menu-icon mdi mdi-account-outline"></i>
        <span class="menu-title">Supplier</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}" href="{{ route('customers.index') }}">
        <i class="menu-icon mdi mdi-account-group-outline"></i>
        <span class="menu-title">Customer</span>
      </a>
    </li>
     <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}">
        <i class="menu-icon mdi mdi-account-group-outline"></i>
        <span class="menu-title">Employee</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('billings.index') ? 'active' : '' }}" href="{{ route('billings.index') }}">
        <i class="menu-icon mdi mdi-receipt-outline"></i>
        <span class="menu-title">Billing</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
        <i class="menu-icon mdi mdi-cart-outline"></i>
        <span class="menu-title">Purchase</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
        <i class="menu-icon mdi mdi-credit-card-outline"></i>
        <span class="menu-title">Expenses</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('paybles.index') ? 'active' : '' }}" href="{{ route('paybles.index') }}">
        <i class="menu-icon mdi mdi-cash-minus"></i>
        <span class="menu-title">Payable</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('emis.index') ? 'active' : '' }}" href="{{ route('emis.index') }}">
        <i class="menu-icon mdi mdi-bank-outline"></i>
        <span class="menu-title">Loan EMI</span>
      </a>
    </li>

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link" href="{{ route('profile.edit') }}">
        <i class="menu-icon mdi mdi-account-outline"></i>
        <span class="menu-title">Profile</span>
      </a>
    </li>

    <li class="nav-item d-block d-lg-none">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link btn btn-link text-start w-100">
          <i class="menu-icon mdi mdi-power text-danger"></i>
          <span class="menu-title">Logout</span>
        </button>
      </form>
    </li>

    
  </ul>
</nav>