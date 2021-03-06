<?php

namespace App\Controllers;

use \App\Models\Lists as Lists;
use \App\Models\Users as Users;
use Respect\Validation\Validator as v;
use Cartalyst\Sentinel\Native\Facades\Sentinel as Sentinel;

class ListController extends BaseController
{
    public function lists($request, $response, $args)
    {
        if ($request->isPost()) {
            $this->remove($request, $response, $args);
        }

        if (! $user = Sentinel::check()) {
            return $response->withRedirect('/login');
        }

        $lists = Users::find($user['id'])->lists;

        $data = [
            "lists" => []
        ];

        foreach ($lists as $l) {
            $info_list = [
                "id" => $l->id,
                "title" => $l->title,
                "date" => date('d/m/Y à H:i', strtotime($l->limit_date)),
                "url" => $l->sharing_url
            ];

            array_push($data["lists"], $info_list);
        }

        return $this->container->view->render($response, 'lists.twig', $data);
    }

    public function add($request, $response, $args)
    {
        if (! $user = Sentinel::check()) {
            return $response->withRedirect('/login');
        }

        $data = [];

        if ($request->isPost()) {
            $params = $request->getParams();
            $errors = [];

            if (! v::alnum('&.,/-?!éèçàùïô"\'()')->length(1, 255)->validate($params['title'])) {
                array_push($errors, "Le titre saisie n'est pas valide ou est trop long !");
            }

            if (! v::alnum('&.,/-?!éèçàùïô"\'()')->length(1, 255)->validate($params['description'])) {
                array_push($errors, "La description comporte des caractères non valides, ou est trop longue !");
            }

            if ($params['self_targeted'] === "false" && ! v::alpha('-')->length(1, 255)->validate($params['target'])) {
                array_push($errors, "Si vous n'êtes pas le destinataire de la liste, vous devez saisir un destinataire valide !");
            }

            if (! v::Date('d/m/Y H:i')->validate($params['date'])
                || date_create_from_format('d/m/Y H:i', $params['date']) < new \DateTime()
            ) {
                array_push($errors, "Le format de la date spécifiée n'est pas valide !");
            }

            if (sizeof($errors) == 0) {
                $list = new Lists;

                $list->title = $params['title'];
                $list->description = $params['description'];
                $list->limit_date = \Datetime::createFromFormat('d/m/Y H:i', $params['date']);
                $list->is_self_target = $params['self_targeted'] === "true" ? true : false ;
                $list->receiver = $params['self_targeted'] === "true" ? $params['target'] : "";
                $list->sharing_url = "";
                $list->users_id = $user['id'];

                $list->save();

                $list->sharing_url = md5($list->id);

                $list->save();

                return $response->withRedirect('/lists');
            } else {
                $data['errors'] = $errors;
            }
        }

        return $this->container->view->render($response, 'addList.twig', $data);
    }

    public function remove($request, $response, $args)
    {
        if (! $user = Sentinel::check()) {
            return $response->widthRedirect('/login');
        }

        $id = $request->getParams()['target'];

        if ($target = Lists::find($id)) {
            if ($target->users_id == $user['id']) {
                $target->delete();
            } else {
                return $response->widthRedirect('/lists');
            }
        } else {
            return $response->widthRedirect('/lists');
        }
    }

}