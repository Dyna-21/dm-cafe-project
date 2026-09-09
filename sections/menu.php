<!-- ===== MENU / FLAVORS ===== -->
<section id="menu" class="py-5" style="background: var(--blush); padding-top:100px !important; padding-bottom:100px !important;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
      <div>
        <p class="eyebrow">The Flavors</p>
        <h2 style="font-size:clamp(28px,3.4vw,36px);">Crafted with Intention</h2>
      </div>
      <a href="cart/view-cart.php" class="btn btn-outline-dark btn-sm px-3">Cart</a>
    </div>

    <!-- Unahang Row (4 ka items) -->
    <div class="row g-4">
      <!-- 1. Espresso -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image.png" alt="Espresso" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Espresso</h3>
              <span class="price">₱150</span>
            </div>
            <p class="small text-muted">Our signature double shot. Bright citrus notes with a deep, chocolatey body.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Espresso">
              <input type="hidden" name="price" value="150">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 2. Vanilla Latte -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-image.png" alt="Vanilla Latte" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Vanilla Latte</h3>
              <span class="price">₱200</span>
            </div>
            <p class="small text-muted">House-made organic Madagascar vanilla bean syrup, micro-foamed milk, and espresso.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Vanilla Latte">
              <input type="hidden" name="price" value="200">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 3. Cold Brew -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image2.png" alt="Cold Brew" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Cold Brew</h3>
              <span class="price">₱100</span>
            </div>
            <p class="small text-muted">Steeped for 18 hours. Smooth, low acidity, naturally sweet with hints of dark cocoa.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Cold Brew">
              <input type="hidden" name="price" value="100">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 4. Matcha Latte -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image3.png" alt="Matcha Latte" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Matcha Latte</h3>
              <span class="price">₱180</span>
            </div>
            <p class="small text-muted">Ceremonial stone-ground Uji matcha whisked to order, served over velvety steamed milk.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Matcha Latte">
              <input type="hidden" name="price" value="180">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>
    </div>

    <!-- Ikaduhang Row (4 ka items) -->
    <div class="row g-4 mt-2">
      <!-- 5. Caramel Macchiato -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image4.png" alt="Caramel Macchiato" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Caramel Macchiato</h3>
              <span class="price">₱220</span>
            </div>
            <p class="small text-muted">Freshly steamed milk with vanilla syrup, marked with espresso and caramel drizzle.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Caramel Macchiato">
              <input type="hidden" name="price" value="220">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 6. Caffe Americano -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image5.png" alt="Caffe Americano" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Caffe Americano</h3>
              <span class="price">₱130</span>
            </div>
            <p class="small text-muted">Rich espresso shots topped with hot water for a clean, robust flavor profile.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Caffe Americano">
              <input type="hidden" name="price" value="130">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 7. Mocha Latte -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image6.png" alt="Mocha Latte" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Mocha Latte</h3>
              <span class="price">₱210</span>
            </div>
            <p class="small text-muted">A harmonious blend of espresso, steamed milk, and rich artisanal chocolate syrup.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Mocha Latte">
              <input type="hidden" name="price" value="210">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>

      <!-- 8. Cappuccino -->
      <div class="col-md-6 col-lg-3">
        <article class="card h-100 border-0" style="background: var(--cream); border-radius:6px; overflow:hidden;">
          <img src="assets/menu-item-image7.png" alt="Cappuccino" class="card-img-top" style="height:170px; object-fit:cover;">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline mb-2">
              <h3 class="h5 mb-0">Cappuccino</h3>
              <span class="price">₱160</span>
            </div>
            <p class="small text-muted">Equal parts espresso, steamed milk, and thick, airy microfoam dusted with cocoa.</p>
            <form method="POST" action="cart/add_to_cart.php" class="d-flex align-items-center gap-2 mt-3">
              <input type="hidden" name="product_name" value="Cappuccino">
              <input type="hidden" name="price" value="160">
              <input type="number" name="quantity" value="1" min="1" max="20" class="form-control form-control-sm" style="width:56px;">
              <button type="submit" class="btn btn-brand-primary btn-sm">Add to Cart</button>
            </form>
          </div>
        </article>
      </div>
    </div>

  </div>
</section>