<div id="sidebar-menu-container" class="flex grow flex-col gap-y-2 overflow-y-auto bg-indigo-600 px-6 pb-4">
    <div class="flex h-16 shrink-0 items-center">
        <img class="h-8 w-auto" src="https://www.broobe.com/wp-content/uploads/2023/02/logo-broobe-1.svg" alt="Broobe Challenge">
    </div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-5">
            <li>
                @include('components.layouts.main.sidebar.appMenu')
            </li>
            <li>
                @include('components.layouts.main.sidebar.topMenu')
            </li>
            <li class="mt-auto">
                @include('components.layouts.main.sidebar.bottomMenu')
            </li>
        </ul>
    </nav>
</div>
