<?php
declare(strict_types=1);

namespace App\Controller;

use App\Traits\InertiaResponseTrait;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagsController extends AppController
{
    use InertiaResponseTrait;

    /**
     * Index method VUE
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $this->paginate['order'] = ['Tags.id' => 'desc'];
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

        $tags = $this->paginate($this->Tags);

        $pagingParams = $this->Paginator->getPagingParams();
        $params = [];
        $params[] = 'sort' . '=' . $pagingParams['Tags']['sort'];
        $params[] = 'direction' . '=' . $pagingParams['Tags']['direction'];
        $params = '&' . implode('&', $params);

        if ($pagingParams['Tags']['page'] > 1) {
            $links[] = ['url'=> 'index?page=1' . $params, 'label' => '<< ' . __('first')];
        }
        if ($pagingParams['Tags']['prevPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Tags']['page']-1) . $params, 'label' => '< ' . __('previous')];
        }
        for ($i=1;$i<=$pagingParams['Tags']['pageCount' ];$i++){
            $links[] = ['url'=> 'index?page=' . $i . $params, 'label'=>$i];
        }
        if ($pagingParams['Tags']['nextPage']) {
            $links[] = ['url'=> 'index?page=' . ($pagingParams['Tags']['page']+1) . $params, 'label' => __('next') . ' >'];
        }
        if ($pagingParams['Tags']['page'] < $pagingParams['Tags']['pageCount']) {
            $links[] = ['url'=> 'index?page=' . $pagingParams['Tags']['pageCount'] . $params, 'label' => __('last') . ' >>'];
        }

        $this->set(compact('tags','links'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Pages'],
        ]);

        $this->set(compact('tag'));
    }

    /**
     * Add method VUE
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $errors = [];
        $tag = $this->Tags->newEmptyEntity();
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('tags');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $tag = $this->Tags->patchEntity($tag, $data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $tag->getErrors();
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }


        $pages = $this->Tags->Pages->find('all', ['limit' => 200])->toArray();
        $this->set(compact('tag', 'pages', 'errors'));
    }

    /**
     * Edit method VUE
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $errors = [];
        $tag = $this->Tags->get($id, [
            'contain' => ['Pages'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $db = \Cake\Datasource\ConnectionManager::get('default');
            $collection = $db->getSchemaCollection();
            $tableSchema = $collection->describe('tags');
            foreach($tableSchema->columns() as $column) {
                if ($tableSchema->getColumnType($column) == 'timestampfractional') {
                    $data[$column] = \Cake\I18n\FrozenDate::parseDate($data[$column],'YYYY-MM-dd');
                }
            }

            $tag = $this->Tags->patchEntity($tag, $data);
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $errors = $tag->getErrors();
            $this->Flash->error(__('The tag could not be saved. Please, try again.'));
        }


    $pages = $this->Tags->Pages->find('all', ['limit' => 200])->toArray();
        $this->set(compact('tag', 'pages', 'errors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
