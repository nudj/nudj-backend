### Basic

```
>>> get_class(App\Models\User::all());
=> "Illuminate\\Database\\Eloquent\\Collection"
```

```
>>> App\Models\User::active();
=> <Illuminate\Database\Eloquent\Builder #000000003ff862b4000000017eba3a69> {}

>>> get_class(App\Models\User::active());
=> "Illuminate\\Database\\Eloquent\\Builder"

```

It looks like we have two main types `Collection` and `Builder`. My understanding is that Builder is an ongoing SQL query being built. And once we have a Builder we can call `->get()` to get the collection.

```
>>> get_class(App\Models\User::active()->get());
=> "Illuminate\\Database\\Eloquent\\Collection"
```

### Example

```

>>> get_class(App\Models\User::where('phone', '=', '+447700900001'))
=> "Illuminate\\Database\\Eloquent\\Builder"

>>> get_class(App\Models\User::where('phone', '=', '+447700900001')->active())
=> "Illuminate\\Database\\Eloquent\\Builder"

>>> get_class(App\Models\User::where('phone', '=', '+447700900001')->active()->first())
=> "App\\Models\\User"
```

