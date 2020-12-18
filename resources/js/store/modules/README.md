# Adam Mackintosh's portfolio

> This application uses **Vuex** for sideways data-loading, and as a single source of truth for client-side data.

## Modules

Within these Vuex modules, you'll notice a couple patterns:

1. In Vuex modules, and the entire code base, a preference exists for predicate functions to keep logic simple and declarative. Predicates will tend to be conventionally prefixed with verbs, such as `isActive` and `hasUsers`, and there is also a preference for "positive, active" logic. For example, it is preferred to use `if` statements such as:

``` javascript
if (isActive && hasUsers) {
    return /* active condition */
}

return /* fallback condition */
```

2. Each module should tend to utilize a Mealy finite state machine via switching over a module `state` field.

``` javascript

```

3. Scalar value event and action types such as `SAVE_THING` should tend to utilize references to foster IDE type-safety and to avoid scalar typos causing downstream bugs.

Here is a template to help a person accelerate up to speed with this application's Vuex module patterns:

*./thing.js*

``` javascript
import axios from 'axios';

// types
export const SAVE_THING = 'SAVE_THING';
export const FETCH_THING = 'FETCH_THING';
export const UPDATE_THING = 'UPDATE_THING';
export const DELETE_THING = 'DELETE_THING';
export const FETCH_ALL_THINGS = 'FETCH_ALL_THINGS';

// getters
export const getters = {};

// mutations
export const mutations = {};

// actions
export const actions = {};

// state
export const state = {};

const thing = {
    namespaced: true,
    getters,
    mutations,
    actions,
    state,
};

export default thing;
```
