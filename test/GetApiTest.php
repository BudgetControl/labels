<?php

use MLAB\PHPITest\Entity\Json;
use Budgetcontrol\Library\Model\Label;
use MLAB\PHPITest\Assertions\JsonAssert;
use Slim\Http\Interfaces\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Budgetcontrol\Label\Controller\LabelController;

class GetApiTest extends \PHPUnit\Framework\TestCase
{

    public function test_get_label_list()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new LabelController();
        $result = $controller->list($request, $response, ['wsid' => 1]);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(200, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/label-list.json'));

        $assertionContent->assertJsonStructure((array) $assertions);
        $assertionContent->assertJsonIsEqualToJson((array) $assertions, [
            'created_at', 'updated_at', 'uuid', 'id', 'date_time', 'color'
        ]);
    }

    public function test_get_label_show()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new LabelController();
        $result = $controller->show($request, $response, ['wsid' => 1, 'label_id' => 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb']);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(200, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/label.json'));

        $assertionContent->assertJsonIsEqualToJson((array) $assertions, [
            'created_at', 'updated_at', 'id', 'date_time', 'color'
        ]);
    }

    public function test_get_label_insert()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->method('getParsedBody')->willReturn([
            'name' => 'JohnDoeTAG'
        ]);

        $controller = new LabelController();
        $result = $controller->insert($request, $response, ['wsid' => 1]);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(201, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/lablel-insert.json'));

        $assertionContent->assertJsonIsEqualToJson((array) $assertions, [
            'created_at', 'updated_at', 'id', 'date_time', 'color', 'uuid'
        ]);
    }

    public function test_get_label_update()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->method('getParsedBody')->willReturn([
            'name' => 'JohnDoeUPDATED',
            'archive' => 0
        ]);

        $controller = new LabelController();
        $result = $controller->update($request, $response, ['wsid' => 1, 'label_id' => 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb']);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(200, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/label-update.json'));

        $assertionContent->assertJsonIsEqualToJson((array) $assertions, [
            'created_at', 'updated_at', 'id', 'date_time', 'color'
        ]);
    }

    public function test_get_label_patch()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $request->method('getParsedBody')->willReturn([
            'archive' => 1
        ]);

        $controller = new LabelController();
        $result = $controller->patch($request, $response, ['wsid' => 1, 'label_id' => 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb']);
        $this->assertEquals(200, $result->getStatusCode());

        $label = Label::where('workspace_id', 1)->where('uuid', 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb')->first();
        $this->assertEquals(1, $label->archive);
        
    }

    public function test_get_label_delete()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new LabelController();
        $result = $controller->delete($request, $response, ['wsid' => 1, 'label_id' => 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb']);

        $this->assertEquals(204, $result->getStatusCode());

        $label = Label::where('workspace_id', 1)->where('uuid', 'bea004bc-d322-4f4b-9aae-5e8a7c8651fb')->first();
        $this->assertNull($label);
        
    }

}
