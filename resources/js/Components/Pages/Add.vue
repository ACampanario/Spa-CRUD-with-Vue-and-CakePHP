
<template>
    <div class="row">
        <div class="column-responsive column-80">
                        <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
            <div class="pages form content">
                <h3>Add Page</h3>
                <form @submit.prevent="submit">

                                                        <label for="title">Title:</label>

                                    <input id="title" v-model="form.title" />

                                                                        <div class="message error" v-if="errors.title">{{ errors.title._empty }}</div>

                                    <label for="description">Description:</label>
                                    <vue-editor id="description" v-model="form.description"></vue-editor>
                                    <br/>
                                <label for="category">Category:</label>
                                <select v-model="form.category_id">
                                    <option disabled value="">Please select one</option>
                                                                        <option v-for="(item, index) in categories" :value="index" :key="index">{{ item }}</option>
                                </select>                                    <label for="published_date">Published_date</label>                                        <date-picker v-model="form.published_date" valueType="format" format="YYYY-MM-DD"></date-picker>
                            <label for="tags">Tags:</label>
                            <div><multiselect v-model="form.tags" :multiple="true" :options="options_tags" label="name" track-by="id"></multiselect></div>

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
            page: Array,
            errors: Array,
            flash: Object|Array,                    tags: Array,                                                categories: Object,    },
        components: {
            VueEditor, DatePicker, Multiselect
        },
        data() {
            return {                        options_tags: [],                                form: {

                                                title: null,
                            description: null,
                            created: null,
                            modified: null,
                            category_id: null,
                            published_date: null,

                                    },
            }
        },
        mounted() {
            console.log('Component mounted.');

                                                    this.form.title = ''
                        this.form.description = ''
                        this.form.created = ''
                        this.form.modified = ''
                        this.form.category_id = ''
                        this.form.published_date = ''
            
                                for(let key in this.tags){
                        this.options_tags.push(this.tags[key]);
                    }
                    for(let key in this.page.tags){
                        this.form.tags.push(this.page.tags[key]);
                    }                    },
        layout: Layout,
        methods: {
            submit() {

                this.form._csrfToken = this.token;

                
                    this.$inertia.post('/pages/add', this.form, {
                        onError: (errors) => {
                            console.log('errors!', errors)
                        },
                        onSuccess: (tag) => console.log('success!', tag),
                    })

                
                
            },
        },
    }
</script>

