<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */

namespace Illuminate\Contracts\View {
    
    /**
     * @method $this layoutData($data = [])
     * @method $this layout($view, $params = [])
     * @method $this extends($view, $params = [])
     * @method $this section($section)
     * @method $this slot($slot)
     */
    class View {}
}

namespace Illuminate\Http {
    
    /**
     * @method RedirectResponse banner($message)
     * @method RedirectResponse dangerBanner($message)
     * @method $this domain(string $domain)
     */
    class RedirectResponse {}
    
    /**
     * @method array validate(array $rules, ...$params)
     * @method array validateWithBag(string $errorBag, array $rules, ...$params)
     * @method bool hasValidSignature($absolute = true)
     * @method bool hasValidRelativeSignature()
     */
    class Request {}
}

namespace Illuminate\Routing {
    
    /**
     * @method $this role($roles = [])
     * @method $this permission($permissions = [])
     */
    class Route {}
}

namespace Illuminate\Support\Facades {
    
    /**
     * @method void emailVerification()
     * @method void auth($options = [])
     * @method void resetPassword()
     * @method void confirmPassword()
     */
    class Route {}
}

namespace Illuminate\Testing {
    
    /**
     * @method $this assertSeeLivewire($component)
     * @method $this assertDontSeeLivewire($component)
     */
    class TestResponse {}
    
    /**
     * @method $this assertSeeLivewire($component)
     * @method $this assertDontSeeLivewire($component)
     */
    class TestView {}
}

namespace Illuminate\View {

    use Livewire\WireDirective;
    
    /**
     * @method WireDirective wire($name)
     */
    class ComponentAttributeBag {}
    
    /**
     * @method $this layoutData($data = [])
     * @method $this layout($view, $params = [])
     * @method $this extends($view, $params = [])
     * @method $this section($section)
     * @method $this slot($slot)
     */
    class View {}
}

namespace Laravel\Ui {
    
    /**
     * @method void argon($command)
     */
    class UiCommand {}
}