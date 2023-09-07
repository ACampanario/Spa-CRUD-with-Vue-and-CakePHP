<template>
    <div>
        <InertiaLink as="button" href="/">Home</InertiaLink>
        <InertiaLink as="button" href="/who-we-are">Who We Are</InertiaLink>
        <div>Who we are VUE</div>
        <p>{{page.text}}</p>
        <p>{{page.other}}</p>
    </div>
</template>

<script>
export default {
    props: {
        page: [],
    },
    components: {
    },
    mounted() {
        console.log('mounted');
        console.log('page', this.page);
    }
}
</script>
