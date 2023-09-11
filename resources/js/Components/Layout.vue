<template>
  <main>
      <header>
          <ul class="row">
            <li style="list-style-type: none; margin:10px 10px 10px 0;"><InertiaLink class="button shadow radius right small" href="/">Dashboard</InertiaLink></li>
            <li style="list-style-type: none; margin:10px 10px 10px 0;"><InertiaLink class="button shadow radius right small" href="/who-we-are">Who We Are</InertiaLink></li>
            <li style="list-style-type: none; margin:10px 10px 10px 0;"><InertiaLink class="button shadow radius right small" href="/pages/index">Pages</InertiaLink></li>
            <li style="list-style-type: none; margin:10px 10px 10px 0;"><InertiaLink class="button shadow radius right small" href="/categories/index">Categories</InertiaLink></li>
            <li style="list-style-type: none; margin:10px 10px 10px 0;"><InertiaLink class="button shadow radius right small" href="/tags/index">Tags</InertiaLink></li>
          </ul>
      </header>
    <article>
      <slot />
    </article>
  </main>
</template>

<script>
import { InertiaLink } from '@inertiajs/inertia-vue'

export default {
  components: {
    InertiaLink,
  }
}
</script>
