<?php

namespace Project\Grid;

class ProjectGrid extends \Nette\Application\UI\Control
{
    public function __construct
    (
        \Project\Repository\ProjectRepository $ProjectRepository
    )
    {
        $this->ProjectRepository = $ProjectRepository;
    }

    /**
     * @var \Project\Repository\ProjectRepository
     */
    private $ProjectRepository;

    /**
     * Grid component
     *
     * @return \Ublaboo\DataGrid\DataGrid
     */
    public function createComponentProjectGrid($name)
    {
        $grid = new \Ublaboo\DataGrid\DataGrid($this, $name);
        $grid->setDataSource($this->ProjectRepository->getTable());
        $grid->setItemsPerPageList([10 => 10, 25 => 25, 50 => 50], FALSE);

        $grid->addColumnText('id', 'ID')
            ->addCellAttributes(['class' => 'col-1'])
            ->setAlign('center')
            ->setSortable()
            ->setFilterText();

        $grid->addColumnText('name', 'Název projektu')
            ->addCellAttributes(['class' => 'col-3'])
            ->setAlign('center')
            ->setSortable()
            ->setFilterText();

        $grid->addColumnDateTime('date_handin', 'Datum odevzdání')
            ->setFormat('d.m.Y')
            ->addCellAttributes(['class' => 'col-3'])
            ->setAlign('center')
            ->setSortable()
            ->setFilterDate();

        $grid->addColumnText('type', 'Druh projektu')
            ->setReplacement(\Project\Dial\ProjectTypeDial::getList())
            ->addCellAttributes(['class' => 'col-3'])
            ->setAlign('center')
            ->setSortable()
            ->setFilterSelect([null => '~ Vše ~'] + \Project\Dial\ProjectTypeDial::getList());

        $grid->addColumnText('web', 'Webový projekt')
            ->addCellAttributes(['class' => 'col-2'])
            ->setAlign('center')
            ->setSortable()
            ->setReplacement([0 => 'Ne', 1 => 'Ano'])
            ->setFilterSelect([null => '~ Vše ~', 0 => 'Ne', 1 => 'Ano']);

        $grid->addAction('edit', '', ':Homepage:projectForm', ['id' => 'id'])
            ->setTitle('Editovat')
            ->setIcon('edit fa-fw')
            ->setClass('btn btn-sm btn-info');

        $grid->addAction('delete', '', '', ['id' => 'id'])
            ->setTitle('Smazat')
            ->setIcon('times fa-fw')
            ->setClass('btn btn-sm btn-danger');

        return $grid;
    }

    /**
     * Action delete
     *
     * @param int $id
     *
     * @flash
     * @redirect
     */
    public function handleDelete($id)
    {
        $projectEntity = $this->ProjectRepository->getByID($id);

        if($projectEntity)
        {
            $this->getPresenter()->flashMessage('Projekt ' . $projectEntity->name . ' byl smazán', 'success');
            $this->ProjectRepository->delete($projectEntity);
        }
        else
        {
            $this->getPresenter()->flashMessage('Došlo k chybě při mazání', 'error');
        }

        $this->getPresenter()->redirect('default');
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . DIRECTORY_SEPARATOR . 'projectGrid.latte');
        $this->template->render();
    }
}