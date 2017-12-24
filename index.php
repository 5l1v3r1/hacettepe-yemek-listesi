<!DOCTYPE html>
<html>

<head>
    <title>Hacettepe Yemek Listesi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body{ background-color: #3d9881; }
    </style>
    <body>
        <div class="container-fluid">
            <div id="saatler" class="alert alert-dismissible alert-dark" style="display: block;">
                <h3 class="text-center">
            <i class="fa fa-cutlery" aria-hidden="true"></i>
            <br>
            Hacettepe Yemek Listesi
        </h3>
                <p class="text-center"><b><i class="fa fa-clock-o" aria-hidden="true"></i> Yemekhane Saatleri:</b></p>
                <p class="text-center"> <b>Hafta İçi:</b> Kahvaltı 08:00 - 09:15 / Öğle 11:30 - 14:00 / Akşam 17:00 - 18:30</p>
                <p class="text-center"> <b>Hafta Sonu:</b> Kahvaltı 09:00 - 10:00 / Öğle 12:00 - 13:30 / Akşam 17:00 - 18:30</p>
                <br>
            </div>

            <div class="card-deck">
                <?php
            date_default_timezone_set('Europe/Istanbul');
            $bugun = new DateTime(date("d.m.Y"));
            $apiURL = 'http://www.sksdb.hacettepe.edu.tr/YemekListesi.xml';
            $sahurDosya = "sahur.".$bugun->format('Y').".xml";
            $yemekListesi = file_get_contents($apiURL);
            $sahurListesi = file_get_contents($sahurDosya);
            $xmlDataYemek = simplexml_load_string($yemekListesi);
            $xmlDataSahur = simplexml_load_string($sahurListesi);
            $kahvalti = ["Pazartesi" => ["Çay-süt", "Sade Poğaça", "Patates Kızartması-Sosis", "Beyaz Peynir", "Siyah Zeytin", "Tereyağ", "Reçel", "Fındık Ezmesi", "Domates-Biber"], "Salı" => ["Çay", "Patatesli Kol Böreği", "Haşlanmış Yumurta", "Poşet Beyaz Peynir", "Yeşil Zeytin", "Tereyağ", "Bal", "Domates-Salatalık"], "Çarşamba" => ["Çay-süt", "Kek", "Menemen*Patatesli Yumurta", "Üçgen Peynir", "Siyah Zeytin", "Tereyağ", "Reçel", "Domates-Salatalık"], "Perşembe" => ["Çay-meyvesuyu", "Peynirli Tepsi Böreği", "Haşlanmış Yumurta", "Kaşar Peyniri", "Yeşil Zeytin", "Tereyağ", "Bal", "Domates-Biber"], "Cuma" => ["Çay", "Simit", "Beyaz Peynir", "Üçgen Peynir", "Siyah Zeytin", "Tereyağ", "Reçel", "Fındık Ezmesi", "Domates-Biber"], "Cumartesi" => ["Çay-süt", "Gözleme", "Haşlanmış Yumurta", "Beyaz Peynir", "Siyah Zeytin", "Tereyağ", "Bal", "Domates-Salatalık"], "Pazar" => ["Çay-süt", "Kaşarlı-sucuklu Tost", "Menemen", "Poşet Beyaz Peynir", "Yeşil Zeytin", "Tereyağ", "Reçel", "Fındık Ezmesi", "Domates-Biber"]];
            $kumanya = ["Pazartesi" => ["Kaşar Peynirli Sandviç", "Ayran", "Mevsim Meyvesi"], "Salı" => ["Konserve Barbunya Pilaki*Fasulye Pilaki", "Meyve Suyu", "Mevsim Meyvesi", "Rol Ekmek (2 adet)"], "Çarşamba" => ["Beyaz Peynirli Sandviç", "Ayran", "Mevsim Meyvesi"], "Perşembe" => ["Konserve Ton Balığı*Barbunya Pilaki", "Meyve Suyu", "Mevsim Meyvesi", "Rol Ekmek (2 adet)"], "Cuma" => ["Kaşar Peynirli Sandviç", "Ayran", "Mevsim Meyvesi"], "Cumartesi" => [""], "Pazar" => [""]];
            foreach($xmlDataYemek->children() as $gun)
            {
                if (new DateTime(substr($gun->tarih, 0, 10)) >= $bugun)
                {
            ?>
                    <div class="card text-white bg-dark mb-3" style="min-width: 20rem;">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $gun->tarih; ?> </h4>
                            <div class="alert alert-dark" role="alert">
                                <h4>Kahvaltı</h4>
                                <ul class="list-group list-group-flush">
                                    <?php
                                        $gunAdi = explode(" ", $gun->tarih) [1];
                                        foreach($kahvalti[$gunAdi] as $yemek)
                                        {
                                            echo '<li class="list-group-item list-group-item-dark text-white">'.$yemek.'</li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="alert alert-dark" role="alert">
                                <h4>Ana Yemek</h4>
                                <ul class="list-group list-group-flush">
                                    <?php
                                        foreach($gun->yemekler->yemek as $yemek)
                                        {
                                            echo '<li class="list-group-item list-group-item-dark text-white">'.$yemek.'</li>';
                                        }

                                        echo '<br><b>' . $gun->kalori . ' Kalori</b>';
                                    ?>
                                </ul>
                            </div>
                            <div class="alert alert-dark" role="alert">
                                <h4>Kumanya</h4>
                                <ul class="list-group list-group-flush">
                                    <?php
                                        $gunAdi = explode(" ", $gun->tarih) [1];
                                        foreach($kumanya[$gunAdi] as $yemek)
                                        {
                                            if ($yemek)
                                            {
                                                echo '<li class="list-group-item list-group-item-dark text-white">'.$yemek.'</li>';
                                            }
                                            else
                                            {
                                                echo "<i>Bugün kumanya menü hizmeti verilmemektedir.</i>";
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                            <?php 
                        $gunler = array(1=>"Pazartesi",2=>"Salı",3=>"Çarşamba",4=>"Perşembe",5=>"Cuma",6=>"Cumartesi",8=>"Pazar");
                        $gun = $gunler[$bugun -> format("w")];
                        $sahur = $xmlDataSahur->xpath('//gunler/gun/tarih[.="'.$bugun->format("d.m.Y").' '.$gun.'"]/parent::*');
                        if ($sahur) {
                        ?>
                                <div class="alert alert-dark" role="alert">
                                    <h4>Sahur</h4>
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        foreach($sahur[0]->yemekler->yemek as $yemek){
                                            echo '<li class="list-group-item list-group-item-dark text-white">'.$yemek.'</li>';

                                        }
                                    }
                                ?>
                                    </ul>
                                </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
            </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/material.min.js"></script>
</html>