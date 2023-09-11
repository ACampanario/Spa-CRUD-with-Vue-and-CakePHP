<template>
  <div class="column-responsive column-80">
      <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
   <div class="pages index content">
       <h3>Pages</h3>
       <InertiaLink href="/pages/add" class="button shadow radius right small">Add Page</InertiaLink>
              <div class="table-responsive">
           <table>
               <thead>
               <tr>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.id" :data="{ sort: 'id', direction: changeDirection }">Id</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.title" :data="{ sort: 'title', direction: changeDirection }">Title</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.created" :data="{ sort: 'created', direction: changeDirection }">Created</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.modified" :data="{ sort: 'modified', direction: changeDirection }">Modified</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.category_id" :data="{ sort: 'category_id', direction: changeDirection }">Category_id</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/pages/index" :class="defaultClass.published_date" :data="{ sort: 'published_date', direction: changeDirection }">Published_date</InertiaLink>
                       </th>
                                      <th class="actions">Actions</th>
               </tr>
               </thead>
               <tbody>
                <tr v-for="page in pages">
                    
                        
                                                                                                                                        
                                                                                                                <td>
                                                                        {{page.id}}
                                </td>
                                                    

                    
                        
                                                                                                                                        
                                                                                                                <td>
                                                                                                            {{page.title}}
                                </td>
                                                    

                    
                        
                                                                                                                                        
                                                                                                                <td>
                                                                        {{ formatDate(page.created) }}
                                </td>
                                                    

                    
                        
                                                                                                                                        
                                                                                                                <td>
                                                                        {{ formatDate(page.modified) }}
                                </td>
                                                    

                    
                        
                                                                                                                                                                                                                                                                        <td>
                                        <span v-if="page.category">
                                            <InertiaLink class=""  :href="'/categories/view/' + page.category.id">{{page.category.title}}</InertiaLink>
                                        </span>
                                    </td>
                                                                                    
                        

                    
                        
                                                                                                                                        
                                                                                                                <td>
                                                                        {{ formatDate(page.published_date) }}
                                </td>
                                                    

                                        <td class="actions">
                        <InertiaLink :href="'/pages/view/' + page.id">View</InertiaLink>
                        <InertiaLink :href="'/pages/edit/' + page.id">Edit</InertiaLink>
                        <InertiaLink :data="{ _csrfToken:token }"  method="post" :href="'/pages/delete/' + page.id">Delete</InertiaLink>
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
   pages: Array,
   token: String,
   flash: Object|Array,
   sort: String,
   direction: String,
   links: Array,
  },
  data() {
   return {
    page: 1,
    currentRoute: '/pages/index',
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
