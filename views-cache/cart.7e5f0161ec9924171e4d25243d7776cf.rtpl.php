<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Carrinho de Compras: </h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <div class="product-content-right">
                    <div class="woocommerce">

                        <form action="/checkout">
                            <!--  <?php if( $error != '' ){ ?> -->
                            <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                            </div>
                            <!-- <?php } ?> -->
                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Produto</th>
                                        <th class="product-price">Preço</th>
                                        <th class="product-quantity">Quantidade</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove" href="/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/remove">Ø</a> 
                                        </td>

                                        <td class="product-thumbnail">
                                            <a href="/products/<?php echo htmlspecialchars( $value1["desurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"></a>
                                        </td>

                                        <td class="product-name">
                                            <a href="/products/<?php echo htmlspecialchars( $value1["desurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a> 
                                            <h6> Comprimento: <?php echo htmlspecialchars( $value1["vllength"], ENT_COMPAT, 'UTF-8', FALSE ); ?> -
                                                Largura: <?php echo htmlspecialchars( $value1["vlwidth"], ENT_COMPAT, 'UTF-8', FALSE ); ?> -
                                                Altura: <?php echo htmlspecialchars( $value1["vlheight"], ENT_COMPAT, 'UTF-8', FALSE ); ?> -
                                                Peso: <?php echo htmlspecialchars( $value1["vlweight"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
                                            </h6>
                                        </td>

                                        <td class="product-price">
                                            <span class="amount">R$ <?php echo formatPrice($value1["vlprice"]); ?> </span> 
                                        </td>

                                        <td class="product-quantity">
                                            <div class="quantity buttons_added">
                                                <input type="button" class="minus" value="-" onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/minus'">
                                                <input type="number" size="4" class="input-text qty text" title="Qty" value="<?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" min="0" step="1">
                                                <input type="button" class="plus" value="+" onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add'">
                                            </div>
                                        </td>

                                        <td class="product-subtotal">
                                            <span class="amount">R$ <?php echo formatPrice($value1["vltotal"]); ?></span> 
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <div class="cart-collaterals">

                                <div class="cross-sells">

                                    <h2>Cálculo de Frete</h2>
                                    
                                    <div class="coupon">
                                        <label for="cep">CEP Destino:</label>
                                        <input type="text" placeholder="00000-000" value="<?php echo htmlspecialchars( $cart["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="cep" class="input-text" name="zipcode">
                                        <input type="submit" formmethod="post" formaction="/cart/freight" value="CALCULAR" class="button">
                                    <hr>
                                    
                                    <h5>Detalhes do Frete </h5>
                                    
                                    <p class="shipping" style="font-size: 8px;" >
                                        "Codigo":"40010" <br> 
                                        'sCepOrigem'=>'09853120' <br> 
                                        'sCepDestino'=><?php echo htmlspecialchars( $cart["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <br> 

                                        'ValorMaoPropria=0,00' <br>
                                        'ValorAvisoRecebimento=0,00' <br>
                                        'ValorValorDeclarado:0,00' <br>
                                        'EntregaDomiciliar:N'<br>
                                        'EntregaSabado:N' <br>
                                        'ValorSemAdicionais:0,00'
                                    </p>
                                    
                                    </div>
                                    
                                    <hr>
                                    <!--
                                    <h5>Detalhes do Frete </h5>
                                    
                                    <p class="shipping" style="font-size: 8px;" >
                                        "Codigo":"40010"<br> 
                                        "ValorMaoPropria":"0,00"<br>
                                        "ValorAvisoRecebimento":"0,00"<br>
                                        "ValorValorDeclarado":"0,00"<br>
                                        "EntregaDomiciliar":{},<br>
                                        "EntregaSabado":{},<br>
                                        "ValorSemAdicionais":"0,00"
                                    </p>
                                    -->
                                    
                                </div>

                                <div class="cart_totals ">

                                    <h2>Resumo da Compra</h2>

                                    <table cellspacing="0">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="amount">R$<?php echo formatPrice($cart["vlsubtotal"]); ?></span></td>
                                            </tr>

                                            <tr class="shipping">
                                                <th>Frete</th>
                                                <td>R$ <?php echo formatPrice($cart["vlfreight"]); ?>
                                                    <?php if( $cart["nrdays"] > 0 ){ ?> <small>prazo de <?php echo htmlspecialchars( $cart["nrdays"], ENT_COMPAT, 'UTF-8', FALSE ); ?> dia(s)</small><?php } ?>
                                                </td>
                                            </tr>

                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong><span class="amount">R$<?php echo formatPrice($cart["vltotal"]); ?></span></strong> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            <div class="pull-right">
                                <input type="submit" value="Finalizar Compra" name="proceed" class="checkout-button button alt wc-forward">
                            </div>


                            </div>



                        </form>

                    </div>                        
                </div>                    
            </div>
        </div>
    </div>
</div>