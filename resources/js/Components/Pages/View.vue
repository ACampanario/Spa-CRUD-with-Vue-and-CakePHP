
<template>
    <div class="column-responsive column-80">
        <div class="pages view content">
                        <h3>{{page.title}}</h3>
            <table>

                                                                                        <tr>
                                <th>Title</th>
                                                                <td>{{page.title}}</td>
                            </tr>
                                                                                                
                            <tr>
                                <th>Category Id</th>
                                <td>
                                                                                                                                                            <span v-if="page.category">
                                            <InertiaLink class=""  :href="'/categories/view/' + page.category.id">{{page.category.title}}</InertiaLink>
                                       </span>
                                </td>
                            </tr>

                                                            
                                                            <tr>
                            <th>Id</th>
                            <td>
                                                                {{page.id}}
                            </td>
                        </tr>
                                    
                                                            <tr>
                            <th>Created</th>
                            <td>
                                                                {{ formatDate(page.created) }}
                            </td>
                        </tr>
                                            <tr>
                            <th>Modified</th>
                            <td>
                                                                {{ formatDate(page.modified) }}
                            </td>
                        </tr>
                                            <tr>
                            <th>Published Date</th>
                            <td>
                                                                {{ formatDate(page.published_date) }}
                            </td>
                        </tr>
                                    
            </table>

                                                <div class="text">
                        <strong>Description</strong>
                        <blockquote>
                                                        <span v-html="page.description"></span>
                        </blockquote>
                    </div>
                            
                                                                        <div class="related">
                    <h4>Tags</h4>

                    <span v-if="page.tags && page.tags.length != 0">

                        <div class="table-responsive">
                            <table>
                                <tr>
                                                                            <th>Id</th>
                                                                            <th>Name</th>
                                                                        <th class="actions">Actions</th>
                                </tr>
                                <tr v-for="tags in page.tags">

                                                                                                                    <td>{{tags.id}}</td>
                                                                                                                    <td>{{tags.name}}</td>
                                    
                                                                        <td class="actions">
                                        <InertiaLink as="button" :href="'/tags/view/' + tags.id">View</InertiaLink>
                                        <InertiaLink as="button" :href="'/tags/edit/' + tags.id">Edit</InertiaLink>
                                        <InertiaLink as="button" method="post" :href="'/tags/delete/' + tags.id">Delete</InertiaLink>
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
        page: Object|Array,
    },
    data() {
        return {
            currentRoute: '/pages/view',
            defaultClass: {
                                        title: '',
                        description: '',
                        created: '',
                        modified: '',
                        category_id: '',
                        published_date: '',
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
