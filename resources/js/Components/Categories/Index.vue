<template>
  <div class="column-responsive column-80">
      <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
   <div class="categories index content">
       <h3>Categories</h3>
       <InertiaLink href="/categories/add" class="button shadow radius right small">Add Category</InertiaLink>
              <div class="table-responsive">
           <table>
               <thead>
               <tr>
                                          <th scope="col">
                        <InertiaLink href="/categories/index" :class="defaultClass.id" :data="{ sort: 'id', direction: changeDirection }">Id</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/categories/index" :class="defaultClass.title" :data="{ sort: 'title', direction: changeDirection }">Title</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/categories/index" :class="defaultClass.created" :data="{ sort: 'created', direction: changeDirection }">Created</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/categories/index" :class="defaultClass.modified" :data="{ sort: 'modified', direction: changeDirection }">Modified</InertiaLink>
                       </th>
                                      <th class="actions">Actions</th>
               </tr>
               </thead>
               <tbody>
                <tr v-for="category in categories">
                    
                        
                        
                                                                                                                <td>
                                                                        {{category.id}}
                                </td>
                                                    

                    
                        
                        
                                                                                                                <td>
                                                                                                            {{category.title}}
                                </td>
                                                    

                    
                        
                        
                                                                                                                <td>
                                                                        {{ formatDate(category.created) }}
                                </td>
                                                    

                    
                        
                        
                                                                                                                <td>
                                                                        {{ formatDate(category.modified) }}
                                </td>
                                                    

                                        <td class="actions">
                        <InertiaLink :href="'/categories/view/' + category.id">View</InertiaLink>
                        <InertiaLink :href="'/categories/edit/' + category.id">Edit</InertiaLink>
                        <InertiaLink :data="{ _csrfToken:token }"  method="post" :href="'/categories/delete/' + category.id">Delete</InertiaLink>
                    </td>
                </tr>
               </tbody>
           </table>
       </div>
       <span v-if="links.length > 1">
           <div class="paginator">
               <ul class="pagination">
                   <template v-for="(link, key) in links">
                       <li>
                                                      <InertiaLink :key="key" class="" :href="link.url">{{ link.label }}</InertiaLink>
                       </li>
                   </template>
               </ul>
           </div>
       </span>
   </div>
  </div>
</template>

<script>
 import Layout from '@/Components/Layout'
 import moment from 'moment'
 export default {
  props: {
   categories: Array,
   token: String,
   flash: Array,
   sort: String,
   direction: String,
   links: Array,
  },
  data() {
   return {
    page: 1,
    currentRoute: '/categories/index',
    defaultClass: {
     id: '',
     name: '',
    }
   };
  },
  computed: {
   changeDirection(p) {
    if (this.direction === 'desc') {
     return 'asc';
    } else {
     return 'desc';
    }
   }
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
