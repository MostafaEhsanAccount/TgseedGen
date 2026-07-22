<x-admin-layout>
    <x-slot name="header">
        <h2 class="page-title">لوحة تحكم المنصة</h2>
    </x-slot>

    <div class="row row-deck row-cards">
        <div class="col-6 col-md-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="text-secondary">عدد التينانتس</div>
                    <div class="h1 mb-0">{{ $tenantCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="text-secondary">عدد المستخدمين</div>
                    <div class="h1 mb-0">{{ $userCount }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
