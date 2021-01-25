<?php
require_once 'inc/session.php.inc';
include '../classes/troiAPI/ApiHourBilling.php';
require __DIR__ . '/../vendor/autoload.php';
include_once 'DBTroiConnections.php';
include_once 'PMSActions.php';


use GuzzleHttp\Exception\GuzzleException;

class TroiConnector extends PMSActions
{
    private function getAuthDataByConnectionId($connectionId)
    {
        $dbTroiConnections = new DBTroiConnections();
        $authData = $dbTroiConnections->getConnectionById($connectionId, $_SESSION['userid']);
        return $authData;
    }


    public function getCustomersByClientId($connectionId, $clientId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/customers/?auth=Basic+' . $hashString . '&clientId=' . $clientId);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getCustomersByClientId($connectionId, $clientId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getCustomersByClientId($connectionId, $clientId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    public function getClientsByConnectionId($connectionId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($connectionId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/clients/?auth=Basic+' . $hashString);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getClientsByConnectionId($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getClientsByConnectionId($connectionId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    public function getProjectsByClientIdAndCustomerId($troiHostId, $troiClientId, $troiCustomerId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/projects/?auth=Basic+' . $hashString . '&clientId=' . $troiClientId . '&customerId=' . $troiCustomerId);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getProjectsByClientIdAndCustomerId($troiHostId, $troiClientId, $troiCustomerId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getProjectsByClientIdAndCustomerId($troiHostId, $troiClientId, $troiCustomerId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    public function getCalculationPositionsByClientIdAndProjectId($troiHostId, $troiClientId, $troiProjectId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/calculationPositions/?auth=Basic+' . $hashString . '&clientId=' . $troiClientId . '&projectId=' . $troiProjectId);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getCalculationPositionsByClientIdAndProjectId($troiHostId, $troiClientId, $troiProjectId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getCalculationPositionsByClientIdAndProjectId($troiHostId, $troiClientId, $troiProjectId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    public function getCalculationPositionsByClientId($troiHostId, $troiClientId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/calculationPositions/?auth=Basic+' . $hashString . '&clientId=' . $troiClientId);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getCalculationPositionsByClientId($troiHostId, $troiClientId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print("Error Occured! " . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getCalculationPositionsByClientId($troiHostId, $troiClientId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    public function addWorklogToCalculitionPosition($troiHostId, $troiClientId, $calculationPositionId, $date, $note, $quantity)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));
            $apiEmployee = $this->getCurrentEmployee($troiHostId);
            $apiClient = $this->getClient($troiHostId, $troiClientId);
            $apiCalculationPosition = $this->getCalculationPosition($troiHostId, $calculationPositionId);
            $apiHourBilling = $this->createAPIHourBillingObject($apiClient, $apiCalculationPosition, $apiEmployee, $date, $note, $quantity);

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $authData[0]['host'] . '/api/v2/rest/billings/hours/?auth=Basic+' . $hashString, [
                'json' => ['Date' => $apiHourBilling->getDate(),
                    'Service' => null,
                    'id' => null,
                    'Path' => null,
                    'Id' => null,
                    'documentComputedTotalNet' => 0,
                    'IsInvoiced' => false,
                    'IsBilled' => false,
                    'IsBillable' => true,
                    'IsDeleted' => false,
                    'Employee' => [
                        'Path' => $apiHourBilling->getEmployee()->Path,
                        'id' => $apiHourBilling->getEmployee()->id,
                        'Id' => $apiHourBilling->getEmployee()->Id,
                        'IsDeleted' => $apiHourBilling->getEmployee()->IsDeleted,
                        'ETag' => $apiHourBilling->getEmployee()->ETag,
                        'ClassName' => $apiHourBilling->getEmployee()->ClassName
                    ],
                    'Remark' => $apiHourBilling->getRemark(),
                    'IsApproved' => $apiHourBilling->getIsApproved(),
                    'ETag' => $apiHourBilling->getETag(),
                    'ClassName' => $apiHourBilling->getClassName(),
                    'Client' => [
                        'Path' => $apiHourBilling->getClient()->Path,
                        'id' => $apiHourBilling->getClient()->id,
                        'Id' => $apiHourBilling->getClient()->Id,
                        'IsDeleted' => $apiHourBilling->getClient()->IsDeleted,
                        'Name' => $apiHourBilling->getClient()->Name,
                        'ETag' => $apiHourBilling->getClient()->ETag,
                        'ClassName' => $apiHourBilling->getClient()->ClassName
                    ],
                    'DisplayPath' => $apiHourBilling->getDisplayPath(),
                    'Quantity' => $apiHourBilling->getQuantity(),
                    'CalculationPosition' => [
                        'Path' => $apiHourBilling->getCalculationPosition()->Path,
                        'id' => $apiHourBilling->getCalculationPosition()->id,
                        'Id' => $apiHourBilling->getCalculationPosition()->Id,
                        'IsDeleted' => $apiHourBilling->getCalculationPosition()->IsDeleted,
                        'IsPrintable' => $apiHourBilling->getCalculationPosition()->IsPrintable,
                        'IsFavorite' => $apiHourBilling->getCalculationPosition()->IsFavorite,
                        'Name' => $apiHourBilling->getCalculationPosition()->Name,
                        'ETag' => $apiHourBilling->getCalculationPosition()->ETag,
                        'ClassName' => $apiHourBilling->getCalculationPosition()->ClassName
                    ]
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in addWorklogToCalculitionPosition($troiHostId, $troiClientId, $calculationPositionId, $date, $note, $quantity).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in addWorklogToCalculitionPosition($troiHostId, $troiClientId, $calculationPositionId, $date, $note, $quantity).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    private function getCurrentEmployee($troiHostId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/misc/currentEmployee/?auth=Basic+' . $hashString);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getCurrentEmployee($troiHostId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getCurrentEmployee($troiHostId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    private function getClient($troiHostId, $clientId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/clients/' . $clientId . '/?auth=Basic+' . $hashString);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getClient($troiHostId, $clientId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getClient($troiHostId, $clientId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    private function getCalculationPosition($troiHostId, $calculationPositionId)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($troiHostId);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/calculationPositions/' . $calculationPositionId . '/?auth=Basic+' . $hashString);

            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            $this->createLogger()->error('Exception in getCalculationPosition($troiHostId, $calculationPositionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (GuzzleException $ex) {
            $this->createLogger()->error('Guzzle Exception in getCalculationPosition($troiHostId, $calculationPositionId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }

    private function createAPIHourBillingObject($apiClient, $apiCalculationPosition, $apiEmployee, $date, $note, $quantity)
    {
        $apiBillingObject = new \ApiHourBilling();
        $apiBillingObject->setDate($date);
        $apiBillingObject->setService(null);
        $apiBillingObject->setId(null);
        $apiBillingObject->setPath(null);
        $apiBillingObject->setBId(null);
        $apiBillingObject->setDocumentComputedTotalNet(null);
        $apiBillingObject->setIsInvoiced(false);
        $apiBillingObject->setIsBilled(false);
        $apiBillingObject->setIsBillable(true);
        $apiBillingObject->setIsDeleted(false);
        $apiBillingObject->setEmployee($apiEmployee);
        $apiBillingObject->setRemark($note);
        $apiBillingObject->setIsApproved(true);
        $apiBillingObject->setETag(null);
        $apiBillingObject->setClassName('ApiHourBilling');
        $apiBillingObject->setClient($apiClient);
        $apiBillingObject->setDisplayPath(null);
        $apiBillingObject->setCalculationPosition($apiCalculationPosition);
        $apiBillingObject->setQuantity($quantity);
        return $apiBillingObject;
    }

    //Testing if the given connection is able to fetch any clients
    public function testConnection($id)
    {
        try {
            $authData = $this->getAuthDataByConnectionId($id);
            $hashString = base64_encode($authData[0]['user'] . ':' . md5($authData[0]['password']));

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $authData[0]['host'] . '/api/v2/rest/clients/?auth=Basic+' . $hashString);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->createLogger()->error('Exception in getClientsByConnectionId($connectionId).' . ' Error: ' . $e->getMessage() . ', ' . $e->getTraceAsString());
            print('Error Occured! ' . $e->getMessage());
        } catch (Exception $ex) {
            $this->createLogger()->error('Guzzle Exception in getClientsByConnectionId($connectionId).' . ' Error: ' . $ex->getMessage() . ', ' . $ex->getTraceAsString());
            print('Error Occured! ' . $ex->getMessage());
        }
    }
}