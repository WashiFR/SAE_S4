<?php

namespace admin\app\actions;

use admin\app\actions\AbstractAction;
use admin\app\utils\CsrfException;
use admin\app\utils\CsrfService;
use admin\core\services\entree\EntreService;
use admin\core\services\entree\IEntreeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;

class PostNewEntreeAction extends AbstractAction
{
    protected string $template = '';
    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        try {
            CsrfService::check($data['csrf']);
        } catch (CsrfException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        // Enregistrement de l'image dans le dossier public/assets/img
        $img = $request->getUploadedFiles()['img'];
        if (isset($img) && $img->getError() === UPLOAD_ERR_OK) {
            $extention = pathinfo($img->getClientFilename(), PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $extention;
            $img->moveTo(__DIR__ . '/../../../html/assets/img/' . $fileName);
            $data['img'] = $fileName;
        } else {
            $data['img'] = 'default-profile.jpg';
        }

        $entree_id = $this->entreeService->createEntree(
            [
                'img' => $data['img'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'fonction' => $data['fonction'],
                'num_bureau' => $data['num_bureau'],
                'num_fixe' => $data['num_fixe'] ?? null,
                'num_mobile' => $data['num_mobile'],
                'email' => $data['email'],
            ],
            $data['departements_id'],
            $data['services_id']
        );

        $routeContext = RouteContext::fromRequest($request);
        $url = $routeContext->getRouteParser()->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}