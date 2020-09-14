<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct
    (
        \Project\Repository\ProjectRepository $ProjectRepository,
        \Project\Form\IProjectFormFactory $IProjectFormFactory,
        \Project\Grid\IProjectGridFactory $IProjectGridFactory
    )
    {
        parent::__construct();

        $this->ProjectRepository = $ProjectRepository;
        $this->IProjectFormFactory = $IProjectFormFactory;
        $this->IProjectGridFactory = $IProjectGridFactory;
    }

    /**
     * @var \Project\Repository\ProjectRepository
     */
    private $ProjectRepository;

    /**
     * @var \Project\Form\IProjectFormFactory
     */
    private $IProjectFormFactory;

    /**
     * @var \Project\Grid\IProjectGridFactory
     */
    private $IProjectGridFactory;

    /**
     * Create project form component
     *
     * @return \Project\Form\ProjectForm
     */
    public function createComponentProjectForm()
    {
        $control = $this->IProjectFormFactory->create();
        $control->setup($this->getParameter('id'));

        return $control;
    }

    /**
     * Create project Grid component
     *
     * @return \Project\Grid\ProjectGrid
     */
    public function createComponentProjectGrid()
    {
        return $this->IProjectGridFactory->create();
    }

    /**
     * Action handler
     * 
     * @param int|null $id
     */
    public function actionProjectForm(int $id = null)
    {
        if($id)
        {
            if(!$this->ProjectRepository->getByID($id))
            {
                $this->flashMessage('Tento záznam neexistuje', 'error');
                $this->redirect('default');
            }
        }
    }
}
