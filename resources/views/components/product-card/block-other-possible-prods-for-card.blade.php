@if(isset($resultOtherProductsForCard['products']))
    <div class="card-product__{{ $resultOtherProductsForCard['classComponent'] }}-choice">         
    @if($resultOtherProductsForCard['choiceComment'])
    <div class="d-flex flex-wrap card-product__dif-props">
        {!! $resultOtherProductsForCard['choiceComment'] !!}
    @endif
        
    @foreach ($resultOtherProductsForCard['products'] as $product)
    <a href="{{ $product->prod_url_semantic }}">
        @if($resultOtherProductsForCard['href'])<img src="/storage/{{ $product->img_link }}" alt="{{ $product->colour }}" title ="{{ $product->colour }}">@endif</a>
    @endforeach
        
    @if($resultOtherProductsForCard['choiceComment'])
    </div>
    @endif    
    </div>    
@endif

             

