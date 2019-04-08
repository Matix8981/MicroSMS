<?php
    /**
     * @package MicroSMS
     * @author Mateusz Woźnowski <mateusz8981@gmail.com>
     * @link https://github.com/Matix8981/MicroSMS
     * @license https://opensource.org/licenses/MIT The MIT License
     * @version 1.0.0
     */
    namespace Matix8981\Payments\MicroSMS;
    class SMS
    {
        /**
         * @param $clientID - Client ID from billing panel
         * @param $serviceID - Service ID from billing panel
         */
        public function __construct($clientID, $serviceID)
        {
            $this->clientID = $clientID;
            $this->serviceID = $serviceID;
            $this->response = null;
        }

        /**
         * @param $code - SMS code to check
         * @param $number - The number to which the SMS was sent
         * @return array result
         */
        public function ValidateSingle($code, $number)
        {
            if(!is_null($this->clientID) && !is_null($this->serviceID))
            {
                if(is_numeric($this->clientID) && is_numeric($this->serviceID))
                {
                    if(!is_null($number) && is_numeric($number))
                    {
                        if(preg_match("/^[A-Za-z0-9]{8}$/", $code))
                        {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://microsms.pl/api/v2/index.php?userid={$this->clientID}&serviceid={$this->serviceID}&number={$number}&code={$code}",
                                CURLOPT_RETURNTRANSFER => "1",
                            ));

                            $this->response = json_decode(curl_exec($curl), true);
                            if(!is_null($this->response) && is_array($this->response))
                            {
                                return $this->response;
                            }
                            else
                            {
                                throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Błąd podczas nawiązywania połączenia!");
                            }

                            curl_close($curl);
                        }
                        else
                        {
                            throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> code jest niepoprawny!");
                        }
                    }
                    else
                    {
                        throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> number nie jest liczbą bądź jest pusty!");
                    }
                }
                else
                {
                    throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> clientID lub serviceID nie są liczbami!");
                }
            }
            else
            {
                throw new \Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Proszę wprowadzić clientID oraz serviceID!");
            }
        }

        /**
         * @param $code - SMS code to check
         * @return array result
         */
        public function ValidateMulti($code)
        {
            if(!is_null($this->clientID) && !is_null($this->serviceID))
            {
                if(is_numeric($this->clientID) && is_numeric($this->serviceID))
                {
                    if(preg_match("/^[A-Za-z0-9]{8}$/", $code))
                    {
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://microsms.pl/api/v2/multi.php?userid={$this->clientID}&serviceid={$this->serviceID}&code=${code}",
                            CURLOPT_RETURNTRANSFER => "1",
                        ));

                        $this->response = json_decode(curl_exec($curl), true);
                        if(!is_null($this->response) && is_array($this->response))
                        {
                            return $this->response;
                        }
                        else
                        {
                            throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Błąd podczas nawiązywania połączenia!");
                        }
                        curl_close($curl);
                    }
                    else
                    {
                        throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> code jest niepoprawny!");
                    }
                }
                else
                {
                    throw new \RuntimeException("<strong>Matix8981\Payments\MicroSMS\SMS</strong> clientID lub serviceID nie są liczbami!");
                }
            }
            else
            {
                throw new \Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Proszę wprowadzić clientID oraz serviceID!");
            }
        }

        /**
         * @return array result
         */
        public function ValidateResult()
        {
            if(!is_null($this->response) && is_array($this->response) && $this->response["data"]["status"] == 1)
            {
                return array(
                    "status" => true,
                    "used" => false,
                    "service" => $this->response["data"]["service"],
                    "number" => $this->response["data"]["number"],
                    "phone" => $this->response["data"]["phone"],
                    "reply" => $this->response["data"]["reply"],
                );
            }
            elseif($this->response["connect"] == true && $this->response["data"]["status"] == 0 && $this->response["data"]["used"] == 1)
            {
                return array("status" => false, "used" => true);
            }
            else
            {
                return array("status" => false, "used" => false);
            }
        }
    }
?>
