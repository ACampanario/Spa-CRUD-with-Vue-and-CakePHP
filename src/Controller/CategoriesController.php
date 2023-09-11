<?php
declare(strict_types=1);

namespace App\Controller;

use App\Traits\InertiaResponseTrait;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    use InertiaResponseTrait;

    /**
     * Index method VUE
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //$session = $this->getRequest()->getSession();
        //debug($session->read('Flash'));

        $this->paginate['order'] = ['Categories.id' => 'desc'];
        if ($this->request->getQuery('page') !== null) {
            $this->paginate['page'] = $this->request->getQuery('page');
        }
        $sort = $this->getRequest()->getQuery('sort') ?? null;
        $direction = $this->getRequest()->getQuery('direction') ?? null;
        if ($sort != null){
            $this->paginate['order'] = [$sort => $direction];
        }
        $this->set(compact('sort', 'direction'));

        $this->loadComponent('Paginator');

        $categories = $this->paginate($this->Categories);

        $pagingParams = $this->Paginator->getPagingParams();
        $params = [];
        $params[] = 'sort' . '=' . $pagingParams['Categories']['sort'];
        $params[] = 'direction' . '=' . $pagingParams['Categories']['direction'];
        $params = '&' . implode('&', $params);

        if ($pagingParams['Categories']['page'] > 1) {
            $links[] = ['url'=> 'index?page=1' . $params, 'label' => '<< ' . __('first')];
        }
        if ($pagingParams['Categories']['prevPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Categories']['page']-1) . $params, 'label' => '< ' . __('previous')];
        }
        for ($i=1;$i<=$pagingParams['Categories']['pageCount' ];$i++){
            $links[] = ['url'=> 'index?page=' . $i . $params, 'label'=>$i];
        }
        if ($pagingParams['Categories']['nextPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Categories']['page']+1) . $params, 'label' => __('next') . ' >'];
        }
        if ($pagingParams['Categories']['page'] < $pagingParams['Categories']['pageCount']) {
            $links[] = ['url'=> 'index?page=' . $pagingParams['Categories']['pageCount'] . $params, 'label' => __('last') . ' >>'];
        }

        $this->set(compact('categories','links'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Pages'],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method VUE
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $errors = [];
        $category = $this->Categories->newEmptyEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('categories');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $category->getErrors();
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }


        $this->set(compact('category', 'errors'));
    }

    /**
     * Edit method VUE
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $errors = [];
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('categories');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $category->getErrors();
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }


        $this->set(compact('category', 'errors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
