<?php

namespace Pyz\Zed\Antelope\Communication\Controller;

use Faker\Factory as FakerFactory;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Antelope\Business\AntelopeFacadeInterface getFacade()
 */
class IndexController extends AbstractController
{
    /**
     * @param Request $request
     * @return array<string,mixed>
     */
    public function addAction(Request $request): array
    {
        $antelopeLocationTransfer = new AntelopeLocationTransfer();
        $antelopeLocationTransfer->setLocationName(FakerFactory::create()->name());
        $antelopeLocationTransfer = $this->getFacade()->createAntelopeLocation($antelopeLocationTransfer);

        $antelopeTransfer = new AntelopeTransfer();
        $name = $request->get('name');
        if(!$name){
            $name = FakerFactory::create()->name() ;
        }
        $antelopeTransfer->setName($name);
        $antelopeTransfer->setFkAntelopeLocation($antelopeLocationTransfer->getIdLocation());
        $this->getFacade()->createAntelope($antelopeTransfer);

        $locationTransfer = $this->getFacade()->getAntelopeLocationById($antelopeLocationTransfer->getIdLocation());

        return $this->viewResponse([
            'antelope' => $antelopeTransfer,
            'antelopeLocation' => $locationTransfer,
        ]);
    }
}
