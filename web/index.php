<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Garrett Barlocker - CS313</title>
    <link href="materialize/css/materialize.css" type="text/css" rel="stylesheet">
    <link href="css/main.css" type="text/css" rel="stylesheet">
</head>

<body>

    <?php 
    include( $_SERVER['DOCUMENT_ROOT'] . '/nav.php' ); 
    ?>

    <div class='row container'>
        <div class='col s2 m2'>
            <table class='highlight centered bordered'>
                <tr>
                    <td><a href="#Entrepreneurial">Entrepreneurial</a></td>
                </tr>
                <tr>
                    <td><a href="#PointNote">Point Note</a></td>
                </tr>
                <tr>
                    <td><a href="#Bitcoin">Bitcoin</a></td>
                </tr>
                <tr>
                    <td><a href="#Tesla">Tesla</a></td>
                </tr>
                <tr>
                    <td><a href="#AMD">AMD</a></td>
                </tr>
                <tr>
                    <td><a href="#JetSki">Jet Ski</a></td>
                </tr>
            </table>
        </div>

        <div class='col s10'>
            <div class='row container'>
                <a name='Entrepreneurial'>
                    <section id='Entrepreneurial'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='images/candy.jpg'>
                                    <span class='card-title card-panel card-label'>Entrepreneurial</span>
                                </div>
                            </div>
                            <div class='card-content'>
                                <p class='card-text'>Ever since I have been young I have had an entrepreneurial mindset. For example, throughout Middle School and High School I would sell candy bars to other students. I ended up taking about 50 candy bars to school each day, and would normally sell about 30. Each candy bar at a 300% markup.</p>
                            </div>
                        </div>
                    </section>
                </a>

                <a name='PointNote'>
                    <section id='PointNote'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='https://lh3.googleusercontent.com/ByCMU7Qo1Ag3eXkUfqTy8CULRhm_xU5-MVbno_NJoSn1RPeCguS1kc3eNMZ8ehfbnS8=w300-rw'>
                                    <span class='card-title card-panel card-label'>Point Note</span>
                                </div>
                            </div>
                            <div class='card-content center'>
                                <p class='card-text center'>Point Note is an Android application that was built as a result of CS246, but has since switched from a CakePHP, MySQL backend API to use the MEAN stack minus Angular. Point Note allows you, a BYU-Idaho student to stay up-to-date with the most recent activities being provided on campus. Social? Student? Try out Point Note today!</p>
                            </div>
                            <div class="body-text">Point Note - </div>
                            <div class='card-action body-text'>
                                <a href='https://play.google.com/store/apps/details?id=com.pointnote.android'>Google Play Store</a>
                            </div>
                        </div>
                    </section>
                </a>

                <a name='Bitcoin'>
                    <section id='Bitcoin'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='https://images.duckduckgo.com/iu/?u=http%3A%2F%2Fbyvoid.github.io%2Fslides%2Fbitcoin%2Fbitcoin_logo_2.png&f=1'>
                                    <span class='card-title card-panel card-label'>Bitcoin</span>
                                </div>
                            </div>
                            <div class='card-content center'>
                                <p class='card-text center'>I have been following Bitcoin since the Fall of 2012. The market price of one Bitcoin (USD) is currently,
                                    <?php 
                                    $content = file_get_contents("http://api.coindesk.com/v1/bpi/currentprice.json");
                                    // $json = json_decode($content, true);
                                    // couldn't find out how to decend into the json, for now just breaking apart the string
                                    $price = '$'.explode("\"", $content)[37];
                                    $value = substr($price, 0, -2);
                                    echo $value;
                                ?>. When I had first heard about it I was thinking of investing at $30 dollars apiece. The backbone of this technology, the blockchain, is both an interesting social experiment, and a cool way to track value or worth.</p>
                            </div>
                            <div class="body-text">For more information see:</div>
                            <div class='card-action body-text'>
                                <a href='https://bitcoin.org/en/'>Bitcoin.org</a>
                            </div>
                        </div>
                    </section>
                </a>
            </div>

            <div class="center">
                <a name='Bitcoin'>
                    <section id='Bitcoin'>
                        <div class='row'>
                            <div class='col s10 m10'>
                                <iframe width="720" height="480" src="https://www.youtube.com/embed/Gc2en3nHxA4" frameborder="0" allowfullscreen></iframe>
                                <div class='card-content'>
                                    <p class='card-text center'>This video will explain a little bit about Bitcoin, and such</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </a>
            </div>

            <div class='row container'>
                <a name='Tesla'>
                    <section id='Tesla'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='images/tesla.jpg'>
                                    <span class='card-title card-panel card-label'>Tesla Modal 3</span>
                                </div>
                            </div>
                            <div class='card-content'>
                                <p class='card-text'>When I first heard about Tesla they had only released a few of their Tesla Roadsters to the streets. I looked over their designs and loved the direction and mindset that the company had. Along with the fact that Elon Musk was directly involved, also helped my confidence in the goals of Tesla.</p>
                            </div>
                        </div>
                    </section>
                </a>

                <a name='AMD'>
                    <section id='AMD'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='images/vega.jpg'>
                                    <span class='card-title card-panel card-label'>AMD Vega</span>
                                </div>
                            </div>
                            <div class='card-content center'>
                                <p class='card-text center'>Advanced Micro Devices has been lacking in recent years, in both the GPU and CPU market. With their new release of Ryzen, and upcoming release of Vega, and Naples. I have put my money where my mouth is and put my stakes with them.</p>
                            </div>
                        </div>
                    </section>
                </a>

                <a name='JetSki'>
                    <section id='JetSki'>
                        <div class='col s4 m4'>
                            <div class='card'>
                                <div class='card-image'>
                                    <img src='images/jetSki.jpg'>
                                    <span class='card-title card-panel card-label'>'89 JS 550</span>
                                </div>
                            </div>
                            <div class='card-content center'>
                                <p class='card-text center'>As a result of selling candy, I was able to purchase a 1989 JS 550 Jet Ski. I love the ability that these machines give you to have absolute control over where you are going, with the ability to flip directions on a dime. Sadly, these 2 stokes have been banned from all State regulated California lakes.</p>
                            </div>
                        </div>
                    </section>
                </a>
            </div>

        </div>
    </div>
</body>

</html>