# lrvl-rules-t
Laravel Rules for check personal data

### Usage

```
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use MacTape\LaRules\CorrectPhone;

class SomeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', new CorrectPhone],
            'password' => 'required|string|min:6',
        ];
    }
}

```
