<template>
    <div>
        <div>Dashboard VUE</div>
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
