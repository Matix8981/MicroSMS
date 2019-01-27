<?php
    /**
     * @package MicroSMS
     * @author Mateusz Woźnowski <mateusz8981@gmail.com>
     * @link https://github.com/Matix8981/MicroSMS
     * @license   https://opensource.org/licenses/MIT The MIT License
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
        }

        /**
         * @param $code - SMS code to check
         * @param $number - The number to which the SMS was sent
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
                                CURLOPT_URL => "http://microsms.pl/api/v2/index.php?userid={$this->clientID}&serviceid={$this->serviceID}&number={$number}&code={$code}",
                                CURLOPT_RETURNTRANSFER => "1",
                            ));

                            $data = json_decode(curl_exec($curl));
                            if(!is_null($data) && is_object($data))
                            {
                                return $data;
                            }
                            else
                            {
                                throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Błąd podczas nawiązywania połączenia!");
                            }

                            curl_close($curl);
                        }
                        else
                        {
                            throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> code jest niepoprawny!");
                        }
                    }
                    else
                    {
                        throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> number nie jest liczbą bądź jest pusty!");
                    }
                }
                else
                {
                    throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> clientID lub serviceID nie są liczbami!");
                }
            }
            else
            {
                throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Proszę wprowadzić clientID oraz serviceID!");
            }
        }

        /**
         * @param $code - SMS code to check
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
                            CURLOPT_URL => "http://microsms.pl/api/v2/multi.php?userid={$this->clientID}&serviceid={$this->serviceID}&code={$code}",
                            CURLOPT_RETURNTRANSFER => "1",
                        ));

                        $data = json_decode(curl_exec($curl));
                        if(!is_null($data) && is_object($data))
                        {
                            return $data;
                        }
                        else
                        {
                            throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Błąd podczas nawiązywania połączenia!");
                        }

                        curl_close($curl);
                    }
                    else
                    {
                        throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> code jest niepoprawny!");
                    }
                }
                else
                {
                    throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> clientID lub serviceID nie są liczbami!");
                }
            }
            else
            {
                throw new Exception("<strong>Matix8981\Payments\MicroSMS\SMS</strong> Proszę wprowadzić clientID oraz serviceID!");
            }
        }
    }
?>
