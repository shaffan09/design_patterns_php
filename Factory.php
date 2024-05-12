<?php

interface Button
{
    public function render(): void;
}

class HTMLButton implements Button
{
    protected string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function render(): void
    {
        echo "Rendering HTML button with label $this->label";
    }
}

class DesktopButton implements Button
{
    protected string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function render(): void
    {
        echo "Rendering desktop button with label $this->label";
    }
}

abstract class ButtonFactory
{
    abstract protected function getbutton(string $label): Button;

    public function renderButton(string $label)
    {
        $button = $this->getbutton($label);
        $button->render();
    }
}

class WebButtonFactory extends ButtonFactory
{
    protected function getbutton(string $label): Button
    {
        return new HTMLButton($label);
    }
}

class DesktopButtonFactory extends ButtonFactory
{
    protected function getbutton(string $label): Button
    {
        return new DesktopButton($label);
    }
}

function cliendCode(string $buttonLabel, ButtonFactory $buttonFactory)
{
    $buttonFactory->renderButton($buttonLabel);
}

cliendCode("Desktop Button\n", new DesktopButtonFactory());
cliendCode("Web Button\n", new WebButtonFactory());