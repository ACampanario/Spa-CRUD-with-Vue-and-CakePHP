
<template>
    <div class="column-responsive column-80">
        <div class="categories view content">
                        <h3>{{category.title}}</h3>
            <table>

                                                                                        <tr>
                                <th>Title</th>
                                                                <td>{{category.title}}</td>
                            </tr>
                                                            
                                                            <tr>
                            <th>Id</th>
                            <td>
                                                                {{category.id}}
                            </td>
                        </tr>
                                    
                                                            <tr>
                            <th>Created</th>
                            <td>
                                                                {{ formatDate(category.created) }}
                            </td>
                        </tr>
                                            <tr>
                            <th>Modified</th>
                            <td>
                                                                {{ formatDate(category.modified) }}
                            </td>
                        </tr>
                                    
            </table>

                                                <div class="text">
                        <strong>Description</strong>
                        <blockquote>
                                                        <span v-html="category.description"></span>
                        </blockquote>
                    </div>
                            
                                                                        <div class="related">
                    <h4>Pages</h4>

                    <span v-if="category.pages && category.pages.length != 0">

                        <div class="table-responsive">
                            <table>
                                <tr>
                                                                            <th>Id</th>
                                                                            <th>Title</th>
                                                                            <th>Description</th>
                                                                            <th>Created</th>
                                                                            <th>Modified</th>
                                                                            <th>Category Id</th>
                                                                            <th>Published Date</th>
                                                                        <th class="actions">Actions</th>
                                </tr>
                                <tr v-for="pages in category.pages">

                                                                                                                    <td>{{pages.id}}</td>
                                                                                                                    <td>{{pages.title}}</td>
                                                                                                                    <td>{{pages.description}}</td>
                                                                                                                    <td>{{pages.created}}</td>
                                                                                                                    <td>{{pages.modified}}</td>
                                                                                                                    <td>{{pages.category_id}}</td>
                                                                                                                    <td>{{pages.published_date}}</td>
                                    
                                                                        <td class="actions">
                                        <InertiaLink as="button" :href="'/pages/view/' + pages.id">View</InertiaLink>
                                        <InertiaLink as="button" :href="'/pages/edit/' + pages.id">Edit</InertiaLink>
                                        <InertiaLink as="button" method="post" :href="'/pages/delete/' + pages.id">Delete</InertiaLink>
                                    </td>

                                </tr>

                            </table>
                        </div>

                    </span>

                </div>
            
        </div>
    </div>
</template>


<script>
    import Layout from '@/Components/Layout'
    import moment from 'moment'
    export default {
        props: {
        category: Object|Array,
    },
    data() {
        return {
            currentRoute: '/categories/view',
            defaultClass: {
                                        title: '',
                        description: '',
                        created: '',
                        modified: '',
            }
        };
    },
    computed: {
    },
    methods: {
        formatDate(date) {
            return moment(date).format("YYYY-MM-DD")
        }
    },
    mounted() {

    },
    layout: Layout
    }
</script>
