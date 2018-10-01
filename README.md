# Module-Link for Cockpit CMS

ModuleLink Field for [Cockpit CMS](https://github.com/agentejo/cockpit)

work in progress

Copy this addon to `path/to/cockpit/addons/ModuleLink`

Create a new collection with a modulelink field

**Do not name a field "link".** Weird things may happen, see also: [#590](https://github.com/agentejo/cockpit/issues/590). The issue was closed, but it still happens, even without the ModuleLink addon.

## Field Options

```json
{
  "module": "collections"
}
```

or:

```json
{
  "module": "collections",
  "filter": {
    "type": "foo",
    "color": "#FFCE54"
  },
  "display": "_id"
}
```

**filter default:** all entries, values must match exact

**display default:** label || name

## Request

`https://url.to/cockpit/api/collections/get/collectionname?token=xxtoktenxx`

to populate nested module links add:

```json
{
  "populate":"nonsense",
  "populate_module":"1"
}
```

"populate" must exist to trigger the custom _populate function. `"populate":"0"` would cause false too early, but `"populate":"anystring"` is a small hack to still call the method without resolving collection-links.

**Be careful with populating too deep** if you link in circles. You could produce endless loops...

## Output

without population:

```json
    "entries": [
        {
            "mod": [
                {
                    "_id": "modulelinktest5baf427461f97",
                    "name": "modulelinktest",
                    "module": "collections",
                    "display": "modulelinktest"
                }
            ],
            "collectionlink": {
                "_id": "5b771cb933386215c4000193",
                "link": "pages",
                "display": "test no slug"
            },
            "_mby": "5b0fb863a1e1cdoc1879762079",
            "_by": "5b0fb863a1e1cdoc1879762079",
            "_modified": 1538414489,
            "_created": 1538414361,
            "_id": "5bb257193338620a54000092"
        }
    ]
```

## Screenshots

![modulelink01](https://user-images.githubusercontent.com/13042193/46308476-0bf51480-c5ba-11e8-84ab-0d75ec02d633.png)

![modulelink02](https://user-images.githubusercontent.com/13042193/46308478-0bf51480-c5ba-11e8-80cb-075ca388f8f9.png)
