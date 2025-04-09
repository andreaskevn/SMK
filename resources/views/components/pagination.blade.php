@props(['paginator'])

<div class="mt-4">
    {{ $paginator->appends(request()->query())->links() }}
</div>