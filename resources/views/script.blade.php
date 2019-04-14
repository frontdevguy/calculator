<script type = "text/javascript" >
    function initializeCalculator() {
        let clearOnce = false;

        function printValueToScreen(e) {
            const inputValue = this.getAttribute('data-key');
            let resultScreen = document.querySelector('div.result-view')
            resultScreen.innerHTML = resultScreen.innerHTML + inputValue;
        }

        function printOperatorToScreen(e) {
            const operatorSign = this.getAttribute('data-key');
            let resultScreen = document.querySelector('div.result-view')
            resultScreen.innerHTML = resultScreen.innerHTML + operatorSign;
        }

        function clearScreen(e) {
            let resultScreen = document.querySelector('div.result-view');
            const resultScreenLength = resultScreen.innerHTML.length;
            if (resultScreen.innerHTML.length > 0) {
                if (!clearOnce) {
                    resultScreen.innerHTML = resultScreen.innerHTML.substring(0, (resultScreenLength - 1));
                } else {
                    resultScreen.innerHTML = '';
                    document.querySelector('.clear-screen').textContent = "CE";
                    clearOnce = false;
                }
            }
        }

        function evaluateExpression(e) {
            const expression = document.querySelector('div.result-view').innerHTML;
            if (expression.length > 0) {
                const url = "{{ route('evaluate-expression') }}";
                let ajax = new XMLHttpRequest();
                const payload = JSON.stringify({
                    expression, _token: "<?php echo csrf_token(); ?>"
                });
                evaluateExpressionButton.disabled = true; //disable button until result is ready
                ajax.open("POST", url);
                ajax.responseType = 'json';
                ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8');
                ajax.send(payload);
                ajax.onload = () => {
                    if (ajax.readyState === 4) {
                        const { response, status } = ajax;
                        if (status === 200) {
                            document.querySelector('div.expression-view').innerHTML = document.querySelector('div.result-view').innerHTML + ' =';
                            document.querySelector('div.result-view').innerHTML = response.result;
                        } else if (status === 503) {
                            document.querySelector('div.result-view').innerHTML = "Math Error";
                        } else {
                            document.querySelector('div.result-view').innerHTML = "Syntax Error";
                        }
                        document.querySelector('.clear-screen').textContent = "AC";
                        clearOnce = true;
                        evaluateExpressionButton.disabled = false;
                    }
                };
            }
        }

        const inputButtons = document.querySelectorAll("button.input");
        const operatorButtons = document.querySelectorAll("button.operator");
        const clearScreenButton = document.querySelector("button.clear-screen");
        const evaluateExpressionButton = document.querySelector("button.evaluate-expression");

        inputButtons.forEach((inputButton) => inputButton.addEventListener("click", printValueToScreen));
        operatorButtons.forEach((operatorButton) => operatorButton.addEventListener("click", printOperatorToScreen));
        clearScreenButton.addEventListener("click", clearScreen);
        evaluateExpressionButton.addEventListener("click", evaluateExpression);
    }
    window.addEventListener('load',initializeCalculator)
</script>