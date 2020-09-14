<?php

namespace Project\Form;

class ProjectForm extends \Nette\Application\UI\Control
{
    /**
     * Private entity ID
     *
     * @var int
     */
    private $id;

    /**
     * @var \Project\Repository\ProjectRepository
     */
    private $ProjectRepository;

    public function __construct
    (
        \Project\Repository\ProjectRepository $ProjectRepository
    )
    {
        $this->ProjectRepository = $ProjectRepository;
    }

    /**
     * Setup internal id
     *
     * @param int|null $id
     */
    public function setup($id = null)
    {
        $this->id = $id;

        if($id)
        {
            $projectEntity = $this->ProjectRepository->getByID($id);
            $this['form']->setDefaults($projectEntity->toArray());
            $this['form']['date_handin']->setDefaultValue((new \Nette\Utils\DateTime($projectEntity->date_handin))->format('d.m.Y'));
        }
    }

    /**
     * ProjectForm component
     *
     * @return \Contributte\FormsBootstrap\BootstrapForm
     */
    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form;

        $form->addText('name', 'Název projektu')
            ->setRequired()
            ->addRule($form::FILLED, 'Toto pole je povinné');

        $form->addText('date_handin', 'Datum odevzdání projektu')
            ->setHtmlAttribute('class', 'datepicker')
            ->setRequired()
            ->addRule($form::FILLED, 'Toto pole je povinné');

        $form->addSelect('type', 'Typ projektu',\Project\Dial\ProjectTypeDial::getList())
            ->setPrompt('~ Vyberte ~')
            ->setRequired()
            ->addRule($form::FILLED, 'Toto pole je povinné');

        $form->addRadioList('web_project', 'Webový projekt', [0 => 'Ne', 1 => 'Ano'])
            ->setDefaultValue(0);

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = [$this, 'formSuccess'];
        $form->onValidate[] = [$this, 'formValidate'];
        $form->onRender[] = [$this, 'bootstrapRender'];

        return $form;
    }

    /**
     * Success function for form
     *
     * @param \Nette\Forms\Form $form
     * @param \Nette\Utils\ArrayHash $values
     */
    public function formSuccess(\Nette\Forms\Form $form, \Nette\Utils\ArrayHash $values)
    {
        $projectEntity = $this->ProjectRepository->getByID($this->id) ?: new \Project\Entity\ProjectEntity();
        $projectEntity->fillFromArray($form->getValues('array'));
        $projectEntity->date_handin = (new \Nette\Utils\DateTime($values->date_handin))->format('Y.m.d');

        $this->ProjectRepository->save($projectEntity);

        $this->getPresenter()->flashMessage('Projekt ' . $values->name . ' byl úspěšně uložen', 'success');
        $this->getPresenter()->redirect('default');
    }

    /**
     * Validate form inputs
     *
     * @param \Nette\Application\UI\Form $form
     * @return \Nette\Application\UI\Form
     */
    public function formValidate(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues('array');
        if(strtotime($values['date_handin']) === false)
        {
            $form['date_handin']->addError('Špatně zadané datum');
        }

        return $form;
    }

    public function render(...$args)
    {
        $this->template->setFile(__DIR__ . DIRECTORY_SEPARATOR . 'projectForm.latte');
        $this->template->render();
    }

    /**
     * Bootstrap renderer setting
     *
     * @param \Nette\Application\UI\Form $form
     * @return \Nette\Forms\Rendering\DefaultFormRenderer
     */
    public function bootstrapRender(\Nette\Application\UI\Form $form)
    {
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class="form-group row"';
        $renderer->wrappers['pair']['.error'] = 'has-danger';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 col-form-label"';
        $renderer->wrappers['control']['description'] = 'span class=form-text';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';
        $renderer->wrappers['control']['.error'] = 'is-invalid';

        foreach($form->getControls() as $control)
        {
            $type = $control->getOption('type');
            if($type === 'button')
            {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-secondary');
                $usedPrimary = true;

            }
            elseif(in_array($type, ['text', 'textarea', 'select'], true))
            {
                $control->getControlPrototype()->addClass('form-control');

            }
            elseif($type === 'file')
            {
                $control->getControlPrototype()->addClass('form-control-file');

            }
            elseif(in_array($type, ['checkbox', 'radio'], true))
            {
                if($control instanceof Nette\Forms\Controls\Checkbox) {
                    $control->getLabelPrototype()->addClass('form-check-label');
                }
                else
                {
                    $control->getItemLabelPrototype()->addClass('form-check-label');
                }

                $control->getControlPrototype()->addClass('form-check-input');
                $control->getSeparatorPrototype()->setName('div')->addClass('form-check');
            }
        }

        return $renderer;
    }
}