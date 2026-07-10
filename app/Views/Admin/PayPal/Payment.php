<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>
<script>
  // Select the node that will be observed for mutations
  const targetNode = document.querySelector("body");

  // Options for the observer (which mutations to observe)
  const config = {
    attributes: true,
    childList: true,
    subtree: true
  };

  // Callback function to execute when mutations are observed
  const callback = (mutationList, observer) => {
    for (const mutation of mutationList) {
      if (mutation.type === "childList") {
        let headings = document.querySelectorAll('h3');
        headings.forEach(heading => heading.style.fontWeight = 'bold');
        let labels = document.querySelectorAll('.input-label');
        labels.forEach(label => label.style.fontWeight = 'bold');
        labels.forEach(label => label.style.marginTop = '10px');
      } else if (mutation.type === "attributes") {
        console.log(`The ${mutation.attributeName} attribute was modified.`);
      }
    }
  };

  // Create an observer instance linked to the callback function
  const observer = new MutationObserver(callback);

  // Start observing the target node for configured mutations
  observer.observe(targetNode, config);
</script>
<script
  src="https://www.paypal.com/sdk/js?client-id=BAAA12Ji-887SRK4U1kr78m5tIE0xUDNlmrwmnnW4opHtJ3lcgrY2mTagxbSRZKS-uQImc3moIiSgm-taQ&components=hosted-buttons&disable-funding=venmo&currency=USD">
</script>
<!-- <script
  src="https://www.paypal.com/sdk/js?client-id=BAAA12Ji-887SRK4U1kr78m5tIE0xUDNlmrwmnnW4opHtJ3lcgrY2mTagxbSRZKS-uQImc3moIiSgm-taQ&components=hosted-buttons&disable-funding=venmo&currency=USD">
</script> -->

<div id="paypal-container-2XSTH3KRLVCRC"></div>
<hr style='border: 0;
  height: 1px;
  background-color: #000000;'>
<script>
  paypal.HostedButtons({
    hostedButtonId: "2XSTH3KRLVCRC",
  }).render("#paypal-container-2XSTH3KRLVCRC")
</script>

<div id="paypal-container-J7YLZWDNG9NWU"></div>
<hr style='border: 0;
  height: 1px;
  background-color: #000000;'>
<script>
  paypal.HostedButtons({
    hostedButtonId: "J7YLZWDNG9NWU",
  }).render("#paypal-container-J7YLZWDNG9NWU")
</script>

<div id="paypal-container-35XUXL3MCVLUN"></div>
<hr style='border: 0;
  height: 1px;
  background-color: #000000;'>
<script>
  paypal.HostedButtons({
    hostedButtonId: "35XUXL3MCVLUN",
  }).render("#paypal-container-35XUXL3MCVLUN")
</script>

<div id="paypal-container-9S58LBGULBU5C"></div>
<hr style='border: 0;
  height: 1px;
  background-color: #000000;'>
<script>
  paypal.HostedButtons({
    hostedButtonId: "9S58LBGULBU5C",
  }).render("#paypal-container-9S58LBGULBU5C")
</script>

<div id="paypal-container-9S58LBGULBU5C"></div>
<script>
  paypal.HostedButtons({
    hostedButtonId: "9S58LBGULBU5C",
  }).render("#paypal-container-9S58LBGULBU5C")
</script>


<?= $this->endSection() ?>