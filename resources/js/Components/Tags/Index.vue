<template>
  <div class="column-responsive column-80">
      <div onclick="this.classList.add('hidden')" :class="[(flash['element'] === undefined) ? 'hidden' : '','message', (flash['element'] === 'flash-success' ? 'success' : 'error')]">{{ flash['message'] }}</div>
   <div class="tags index content">
       <h3>Tags</h3>
       <InertiaLink href="/tags/add" class="button shadow radius right small">Add Tag</InertiaLink>
              <div class="table-responsive">
           <table>
               <thead>
               <tr>
                                          <th scope="col">
                        <InertiaLink href="/tags/index" :class="defaultClass.id" :data="{ sort: 'id', direction: changeDirection }">Id</InertiaLink>
                       </th>
                                          <th scope="col">
                        <InertiaLink href="/tags/index" :class="defaultClass.name" :data="{ sort: 'name', direction: changeDirection }">Name</InertiaLink>
                       </th>
                                      <th class="actions">Actions</th>
               </tr>
               </thead>
               <tbody>
                <tr v-for="tag in tags">
                    
                        
                        
                                                                                                                <td>
                                                                        {{tag.id}}
                                </td>
                                                    

                    
                        
                        
                                                                                                                <td>
                                                                                                            {{tag.name}}
                                </td>
                                                    

                                        <td class="actions">
                        <InertiaLink :href="'/tags/view/' + tag.id">View</InertiaLink>
                        <InertiaLink :href="'/tags/edit/' + tag.id">Edit</InertiaLink>
                        <InertiaLink :data="{ _csrfToken:token }"  method="post" :href="'/tags/delete/' + tag.id">Delete</InertiaLink>
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
   tags: Array,
   token: String,
   flash: Array,
   sort: String,
   direction: String,
   links: Array,
  },
  data() {
   return {
    page: 1,
    currentRoute: '/tags/index',
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
