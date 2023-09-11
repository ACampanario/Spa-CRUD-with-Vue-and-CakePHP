
<template>
    <div class="column-responsive column-80">
        <div class="tags view content">
                        <h3>{{tag.name}}</h3>
            <table>

                                                                                        <tr>
                                <th>Name</th>
                                                                <td>{{tag.name}}</td>
                            </tr>
                                                            
                                                            <tr>
                            <th>Id</th>
                            <td>
                                                                {{tag.id}}
                            </td>
                        </tr>
                                    
                
            </table>

            
                                                                        <div class="related">
                    <h4>Pages</h4>

                    <span v-if="tag.pages && tag.pages.length != 0">

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
                                <tr v-for="pages in tag.pages">

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
        tag: Array,
    },
    data() {
        return {
            currentRoute: '/tags/view',
            defaultClass: {
                                        name: '',
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
