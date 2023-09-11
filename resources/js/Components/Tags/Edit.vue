
<template>
    <div class="row">
        <div class="column-responsive column-80">
                        <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
            <div class="tags form content">
                <h3>Edit Tag</h3>
                <form @submit.prevent="submit">

                                                        <label for="name">Name:</label>

                                    <input id="name" v-model="form.name" />

                                                                        <div class="message error" v-if="errors.name">{{ errors.name._empty }}</div>

                            <label for="pages">Pages:</label>
                            <div><multiselect v-model="form.pages" :multiple="true" :options="options_pages" label="title" track-by="id"></multiselect></div>

                            <br/>                    
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<script>
    import Layout from '@/Components/Layout'
    import { VueEditor } from "vue2-editor";
    import DatePicker from 'vue2-datepicker';
    import Multiselect from 'vue-multiselect'
    import moment from 'moment';
    import 'vue2-datepicker/index.css';

    export default {
        props: {
            token: String,
            tag: Array,
            errors: Array,
            flash: Object|Array,                    pages: Array,                            },
        components: {
            VueEditor, DatePicker, Multiselect
        },
        data() {
            return {                        options_pages: [],                                form: {

                                                name: null,

                                                    pages: [],
                                                            },
            }
        },
        mounted() {
            console.log('Component mounted.');

            
                                                    this.form.id = this.tag.id
                            this.form.name = this.tag.name
                                for(let key in this.pages){
                        this.options_pages.push(this.pages[key]);
                    }
                    for(let key in this.tag.pages){
                        this.form.pages.push(this.tag.pages[key]);
                    }                    },
        layout: Layout,
        methods: {
            submit() {

                this.form._csrfToken = this.token;

                
                
                    this.$inertia.post('/tags/edit/' + this.form.id, this.form, {
                        onError: (errors) => {
                            console.log('errors!', errors)
                        },
                        onSuccess: (tag) => console.log('success!', tag),
                    })

                
            },
        },
    }
</script>

