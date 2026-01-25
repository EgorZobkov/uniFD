public function fixTransitionReferral($alias)
{

    $this->component->profile->fixTransitionReferral($alias);

    $this->router->goToRoute("home");

}