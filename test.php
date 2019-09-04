<!DOCTYPE.html>
<html>
  <head>
    <title>testando</title>
    <link rel='icon' href='favicon (2).ico' type='image/x-icon' >
    <meta charset=utf-8>
    <style>
      .container {
        /*Alinha tudo que tiver dentro da div com a class container,
          conforme como ela está sendo configurada.
          Sugiro alinhar conforme sua tela, ajustando os campos de margin e left;*/
        position: absolute;
        left:30%;
        margin-left:-110px;
        margin-top:40px;
        color: lavender;
      }
      #image{
        /*Alinha a img de fundo preto ao centro da tela.
          Sugiro alinhar a sua tela, caso fique fora do padrão;
          Só acrescentar ou diminuir os a altura e largura*/
        height: 85%;
        width: 100%;
      }
      #texto{
        /*Tudo que receber o id texto irá ser configurado conforme descrito abaixo,
            caso queira acrescentar algo a sua fonte, pode adicionar aqui.*/
        position: absolute;
        font-size: 32px;
        left: 15px;
        top: 15px;
        text-align: justify;
      }
      #personalizado {
        /*Se tiver algumas palavras específicas que queira chamar a atenção no texto,
          sugiro colocá-las entre labels e acrescentar a id personalizado*/
        text-shadow: 0.1em 0.1em 0.15em #ffffff
      }
      #fundo{
        /*Aqui é para colocar a imagem de fundo na tela.*/
        background-image: url(imagens/spacelove.jpg);
      }
    </style>
  </head>
  <body id="fundo" >
    <div class="container" >
      <img id="image" src="imagens/img_como_colocar_fundo_preto_nas_fotos_16171_orig.jpg"  align="center"/>
      <label id="texto">TESTE</label>
      <p id="texto"> teste <br>
        <label id="personalizado"> datas </label>
        <br>
        Aqui posso digitar o texto que quiser... Se eu quiser ir para outra linha, acrescento a tag &lt;br&gt; <br>
        E aqui estou eu em outra <label id="personalizado"> linha </label>.
      </p>
    </div>
  </body>
</html>