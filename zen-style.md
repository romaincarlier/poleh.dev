# Zen Code Style

## Spaces Inside Parens and Brackets

Always use spaces inside parentheses and square brackets:

```php
if ( $x ) { }
->label( __( 'Foo' ) )
$arr[ 'key' ]
foo( $a, $b )
```

## Method Naming

- Custom (application) methods: `underscore_case` — e.g., `by_map()`, `update_coordinates()`
- Framework-required methods (Filament, Laravel lifecycle, etc.): `camelCase` — e.g., `form()`, `table()`, `register()`, `boot()`

## Union Types

Always use spaces around `|` in union types:

```php
// correct
string | BackedEnum | null
int | float | null

// wrong
string|BackedEnum|null
```

## Opening Braces

Opening brace on the **same line** as the declaration — for **both classes and methods**, no exceptions:

```php
// correct
class Foo {
    public function bar() : void {
        //
    }
}

// wrong
class Foo
{
    public function bar() : void
    {
        //
    }
}
```

## File Layout

`namespace` goes on line 2 - no blank line between `<?php` and `namespace`:

```php
<?php
namespace Modules\Zen\Models;

use Illuminate\Database\Eloquent\Model;
```

## Import Ordering

Group `use` statements by top-level namespace, with a **blank line between each group**. The first group is always this package's own top-level namespace (e.g. `Abacus\` inside abacus-core, `Modules\PoleH\Core\` inside poleh-core), then:

1. This package's own top-level namespace
2. `Filament\`
3. `Illuminate\`
4. Everything else (alphabetical within the group)

```php
use Modules\Zen\Models\Pin;
use Modules\Zen\Enums\PinColor;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;

use Illuminate\Database\Eloquent\Model;

use BackedEnum;
use Carbon\Carbon;
```

## Grouped Imports

Group related imports using curly brace syntax:

```php
use Filament\Forms\Components\{ TextInput, Select, Textarea };
use Modules\Zen\Filament\Resources\MapResource\Pages\{ ListMaps, CreateMap, EditMap };
```

## Translations

All user-visible strings must be wrapped in `__( '...' )`. Labels use **sentence case** — only the first word is capitalised:

```php
->label( __( 'Name' ) )
->label( __( 'Visit date' ) )       // correct
->label( __( 'Visit Date' ) )       // wrong — no Title Case
->navigationGroup( __( 'Geo' ) )
->placeholder( __( 'Enter a value' ) )
```

## No Alignment

Never pad code with extra spaces to make `=`, `=>`, or anything else line up vertically across consecutive lines. One space on each side, always - regardless of how the surrounding lines look:

```php
// correct
protected $signature   = 'abacus:settings';
protected $description = 'Sync settings';

// wrong - do not pad to align the '='
protected $signature   = 'abacus:settings';
protected $description = 'Sync settings';
```

(The two blocks above are meant to look identical after the fix - the point is: single space before/after the operator, every time, never extra padding to line things up.)

## Commit Size

Commit as work completes, in small logical chunks - not one giant commit at the end of a long session. One coherent unit of work (a trait, a resource, a bugfix) is a commit; a whole module is several.

## Class & File Naming

Prefer short, single-concept class names and use folders for context instead of stacking words into the class name. A command, middleware, action, or support class named after its own folder doesn't need to repeat that folder's word in its class name:

```php
// correct
Console/Commands/Settings.php       // class Settings, command "abacus:settings"
Http/Middleware/Maintenance.php     // class Maintenance
Filament/Actions/Next.php           // class Next
Filament/Actions/Previous.php       // class Previous

// wrong
Console/Commands/SyncSettingsCommand.php
Http/Middleware/MaintenanceMiddleware.php
Filament/Actions/NextAction.php
Filament/Actions/PreviousAction.php
```

Only introduce a more specific/compound name once a real collision inside the same folder actually happens - and prefer adding a subfolder over lengthening the name when that happens. This doesn't apply to genuine multi-word domain nouns (a model called `MenuPosition`, a class called `Institution\Category`) - those are one concept, not a stacked disambiguator.

## Arrays — No Trailing Comma on Last Item

The last element of a PHP array must **not** have a trailing comma:

```php
// correct
$arr = [
    'foo',
    'bar',
    'baz'
];

// wrong
$arr = [
    'foo',
    'bar',
    'baz',
];
```

## Filament Schema Fields — Double Blank Line Between Fields

Separate each field (or component) in a Filament schema with a **double blank line**:

```php
Section::make( __( 'Details' ) )->schema( [
    TextInput::make( 'name' )
        ->label( __( 'Name' ) )
        ->required(),

    TextInput::make( 'email' )
        ->label( __( 'Email' ) )
        ->email()
        ->required(),

    Textarea::make( 'note' )
        ->label( __( 'Note' ) )
] );
```

## Comments

- Do **not** output `/** @use HasFactory<ModelFactory> */` PHPDoc comments on trait use statements. Just write `use HasFactory;`.
- Prefer PHPDoc blocks over inline comments. Never add comments unless the logic is exceptionally complex.

## Misc

- Always use curly braces for control structures, even single-line bodies.
- Use PHP 8 constructor property promotion.
- Always declare explicit return types.
