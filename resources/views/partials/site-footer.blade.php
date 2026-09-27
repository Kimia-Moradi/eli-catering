<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-qr">
      {{-- EDIT: qr — decorative placeholder until config('restaurant.menu_url') is set; generate a real one once the production URL exists. --}}
      <div class="footer-qr__code">
        <svg viewBox="0 0 10 10" aria-hidden="true">
          <rect width="10" height="10" fill="#F7F3E9"/>
          <g fill="#2F2F2F">
            <rect x="0" y="0" width="3" height="3"/><rect x="1" y="1" width="1" height="1" fill="#F7F3E9"/>
            <rect x="7" y="0" width="3" height="3"/><rect x="8" y="1" width="1" height="1" fill="#F7F3E9"/>
            <rect x="0" y="7" width="3" height="3"/><rect x="1" y="8" width="1" height="1" fill="#F7F3E9"/>
            <rect x="4" y="0" width="1" height="1"/><rect x="4" y="4" width="2" height="2"/>
            <rect x="7" y="4" width="1" height="1"/><rect x="4" y="7" width="1" height="1"/>
            <rect x="6" y="6" width="1" height="1"/><rect x="8" y="8" width="2" height="1"/>
            <rect x="4" y="9" width="1" height="1"/><rect x="6" y="8" width="1" height="2"/>
          </g>
        </svg>
      </div>
      <p>برای مشاهده منو اسکن کنید</p>
    </div>

    <div class="footer-contact">
      <span class="footer-contact__phone">
        <svg class="icon" aria-hidden="true"><use href="#icon-phone" xlink:href="#icon-phone"/></svg>
        <span class="en" dir="ltr">{{ config('restaurant.phone') }}</span>
      </span>
      <p>{{ config('restaurant.order_hours') ? 'ساعت سفارش: '.config('restaurant.order_hours') : '' }}</p>
    </div>

    <div class="footer-social">
      <span class="footer-social__title">ما را دنبال کنید</span>
      <a href="{{ config('restaurant.instagram_url') }}" target="_blank" rel="noopener">
        <svg class="icon" aria-hidden="true"><use href="#icon-instagram" xlink:href="#icon-instagram"/></svg>
        <span class="en" dir="ltr">&#64;{{ config('restaurant.instagram_handle') }}</span>
      </a>
      <a href="https://wa.me/{{ ltrim(config('restaurant.whatsapp'), '+') }}" target="_blank" rel="noopener">
        <svg class="icon" aria-hidden="true"><use href="#icon-whatsapp" xlink:href="#icon-whatsapp"/></svg>
        واتساپ
      </a>
    </div>

    <div class="footer-decoration" aria-hidden="true">
      <svg class="icon" viewBox="0 0 100 100"><use href="#icon-branch" xlink:href="#icon-branch"/></svg>
    </div>
  </div>
  <div class="footer-bottom">© <span class="en">{{ now()->year }}</span> {{ config('restaurant.name') }} — تمامی حقوق محفوظ است</div>
</footer>
