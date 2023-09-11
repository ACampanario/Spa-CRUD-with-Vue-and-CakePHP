
<template>
    <div class="row">
        <div class="column-responsive column-80">
                        <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
            <div class="categories form content">
                <h3>Edit Category</h3>
                <form @submit.prevent="submit">

                                                        <label for="title">Title:</label>

                                    <input id="title" v-model="form.title" />

                                                                        <div class="message error" v-if="errors.title">{{ errors.title._empty }}</div>

                                    <label for="description">Description:</label>
                                    <vue-editor id="description" v-model="form.description"></vue-editor>
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
            category: Array,
            errors: Array,
            flash: Array,                },
        components: {
            VueEditor, DatePicker, Multiselect
        },
        data() {
            return {                form: {

                                                title: null,
                            description: null,
                            created: null,
                            modified: null,

                                                        },
            }
        },
        mounted() {
            console.log('Component mounted add tag.');

            
                                                    this.form.id = this.category.id
                            this.form.title = this.category.title
                            this.form.description = this.category.description
                            this.form.created = this.category.created
                            this.form.modified = this.category.modified
                    },
        layout: Layout,
        methods: {
            submit() {

                this.form._csrfToken = this.token;

                
                
                    this.$inertia.post('/categories/edit/' + this.form.id, this.form, {
                        onError: (errors) => {
                            console.log('errors!', errors)
                        },
                        onSuccess: (tag) => console.log('success!', tag),
                    })

                
            },
        },
    }
</script>

