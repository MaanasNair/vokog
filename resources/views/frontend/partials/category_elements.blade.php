<div class="card-columns">
    @foreach ($category->subcategories as $subcategory)
        <div class="card shadow-none border-0">
            <ul class="list-unstyled mb-3">
                <li class="fw-700 border-bottom pb-2 mb-3">
                    <a class="text-reset" href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->getTranslation('name') }}</a>
                </li>
                @foreach ($subcategory->subsubcategories as $subsubcategory)
                    <li class="mb-2">
                        <a class="text-reset" href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->getTranslation('name') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
