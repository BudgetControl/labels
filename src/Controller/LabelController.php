<?php
declare(strict_types=1);

namespace Budgetcontrol\Label\Controller;

use Budgetcontrol\Library\Model\Label;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LabelController extends Controller {

    const PATCH_VALUES = ['archive'];

    public function list(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $labels = Label::where('workspace_id', $wsid)->orderBy('name')->get();

        return response($labels->toArray());
    }

    public function show(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $label_id = $args['label_id'];
        $label = Label::where('workspace_id', $wsid)->where('uuid', $label_id)->first();

        if(!$label) {
            return response([
                'success' => false,
                'message' => 'Label not found'
            ], 404);
        }

        return response($label->toArray());
    }

    public function insert(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $data = $request->getParsedBody();
        $label = new Label();
        $label->workspace_id = $wsid;
        $label->name = $data['name'];
        $label->archive = 0;
        $label->color = '';
        $label->uuid = \Ramsey\Uuid\Uuid::uuid4();
        $label->save();

        return response($label->toArray(), 201);
    }

    public function update(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $label_id = $args['label_id'];
        $data = $request->getParsedBody();
        $label = Label::where('workspace_id', $wsid)->where('uuid', $label_id)->first();

        if(!$label) {
            return response([
                'success' => false,
                'message' => 'Label not found'
            ], 404);
        }

        $label->name = $data['name'];
        $label->archive = $data['archive'];
        $label->save();

        return response($label->toArray());
    }

    public function patch(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $label_id = $args['label_id'];
        $data = $request->getParsedBody();

        foreach($data as $key => $value) {
            if(!in_array($key, self::PATCH_VALUES)) {
                return response([
                    'success' => false,
                    'message' => 'Invalid key'
                ], 400);
            }

            $label = Label::where('workspace_id', $wsid)->where('uuid', $label_id)->first();

            if(!$label) {
                return response([
                    'success' => false,
                    'message' => 'Label not found'
                ], 404);
            }

            $label->$key = $value;
            $label->save();
        }

        return response($label->toArray());
    }

    public function delete(Request $request, Response $response, $args)
    {
        $wsid = $args['wsid'];
        $label_id = $args['label_id'];
        $label = Label::where('workspace_id', $wsid)->where('uuid', $label_id)->first();

        if(!$label) {
            return response([
                'success' => false,
                'message' => 'Label not found'
            ], 404);
        }

        $label->delete();

        return response($label->toArray(), 204);
    }
}