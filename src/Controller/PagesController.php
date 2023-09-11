<?php
declare(strict_types=1);

namespace App\Controller;

use App\Traits\InertiaResponseTrait;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 * @method \App\Model\Entity\Page[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    use InertiaResponseTrait;

    public function dashboard()
    {
        $page = [
            'text' => 'hello world 1',
            'other' => 'hello world 2',
        ];
        $this->set(compact('page'));
    }

    public function whoWeAre()
    {
        $page = [
            'text' => 'hello world 3',
            'other' => 'hello world 4',
        ];
        $this->set(compact('page'));
    }

    /**
     * Index method VUE
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories']
        ];

        $this->paginate['order'] = ['Pages.id' => 'desc'];
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

        $pages = $this->paginate($this->Pages);

        $pagingParams = $this->Paginator->getPagingParams();
        $params = [];
        $params[] = 'sort' . '=' . $pagingParams['Pages']['sort'];
        $params[] = 'direction' . '=' . $pagingParams['Pages']['direction'];
        $params = '&' . implode('&', $params);

        if ($pagingParams['Pages']['page'] > 1) {
            $links[] = ['url'=> 'index?page=1' . $params, 'label' => '<< ' . __('first')];
        }
        if ($pagingParams['Pages']['prevPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Pages']['page']-1) . $params, 'label' => '< ' . __('previous')];
        }
        for ($i=1;$i<=$pagingParams['Pages']['pageCount' ];$i++){
            $links[] = ['url'=> 'index?page=' . $i . $params, 'label'=>$i];
        }
        if ($pagingParams['Pages']['nextPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Pages']['page']+1) . $params, 'label' => __('next') . ' >'];
        }
        if ($pagingParams['Pages']['page'] < $pagingParams['Pages']['pageCount']) {
            $links[] = ['url'=> 'index?page=' . $pagingParams['Pages']['pageCount'] . $params, 'label' => __('last') . ' >>'];
        }

        $this->set(compact('pages','links'));
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => ['Categories', 'Tags'],
        ]);

        $this->set(compact('page'));
    }

    /**
     * Add method VUE
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $errors = [];
        $page = $this->Pages->newEmptyEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('pages');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $page = $this->Pages->patchEntity($page, $data);
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $page->getErrors();
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }

    $categories = $this->Pages->Categories->find('list', ['limit' => 200])->toArray();

        $tags = $this->Pages->Tags->find('all', ['limit' => 200])->toArray();
        $this->set(compact('page', 'categories', 'tags', 'errors'));
    }

    /**
     * Edit method VUE
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $errors = [];
        $page = $this->Pages->get($id, [
            'contain' => ['Tags'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('pages');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $page = $this->Pages->patchEntity($page, $data);
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $page->getErrors();
            $this->Flash->error(__('The page could not be saved. Please, try again.'));
        }

    $categories = $this->Pages->Categories->find('list', ['limit' => 200])->toArray();

    $tags = $this->Pages->Tags->find('all', ['limit' => 200])->toArray();
        $this->set(compact('page', 'categories', 'tags', 'errors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The page has been deleted.'));
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
