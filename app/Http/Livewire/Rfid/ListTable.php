<?php

namespace App\Http\Livewire\Rfid;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\Product\Entities\Product;

class ListTable extends Component
{

    public $listeners = ['productSelected','addProduk', 'discountModalRefresh'];

    public $reload;
    public $cart_instance;
    public $global_discount;
    public $global_tax;
    public $shipping;
    public $quantity;
    public $location;
    public $product;
    public $check_quantity;
    public $discount_type;
    public $item_discount;
    public $data;
    public $add_produk =0;
    public $hitung =0;
    public $jumlah =0;

    public function mount($cartInstance, $data = null) {



        $this->cart_instance = $cartInstance;

        if ($data) {
            $this->data = $data;
            $this->global_discount = $data->discount_percentage;
            $this->global_tax = $data->tax_percentage;
            $this->shipping = $data->shipping_amount;
            $this->jumlah = $data->id;
            $this->updatedGlobalTax();
            $this->updatedGlobalDiscount();

            $cart_items = Cart::instance($this->cart_instance)->content();

            foreach ($cart_items as $cart_item) {
                $this->check_quantity[$cart_item->id] = [$cart_item->options->stock];
                $this->quantity[$cart_item->id] = $cart_item->qty;
                $this->location[$cart_item->location] = $cart_item->location;
                $this->image[$cart_item->location] = $cart_item->location;

                $this->discount_type[$cart_item->id] = $cart_item->options->product_discount_type;
                if ($cart_item->options->product_discount_type == 'fixed') {
                    $this->item_discount[$cart_item->id] = $cart_item->options->product_discount;
                } elseif ($cart_item->options->product_discount_type == 'percentage') {
                    $this->item_discount[$cart_item->id] = round(100 * ($cart_item->options->product_discount / $cart_item->price));
                }
            }
        } else {
            $this->image = '';
            $this->global_discount = 0;
            $this->jumlah = 0;
            $this->global_tax = 0;
            $this->shipping = 0.00;
            $this->check_quantity = [];
            $this->quantity = [];
            $this->discount_type = [];
            $this->item_discount = [];
        }
    }

    public function render() {
        $product =  'product';
        $cart_items = Cart::instance($this->cart_instance)->content();
            return view('livewire.rfid.list-table', [
            'cart_items' => $cart_items,
            'product' => $product
        ]);
    }

    public function productSelected($value) {

           $cart = Cart::instance($this->cart_instance);
            if ($value) {
             //  dd($value);
              foreach ($value as $product) {

                 $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
                         return $cartItem->id == $product['id'];
                           //dd($product);
                        });
                if ($exists->isNotEmpty()) {
                            session()->flash('message', 'Product sudah ada di List!');
                             $this->emit('reload');
                            return;
                        }
                if (!is_array($product)) {
                        session()->flash('message', 'Product tidak ada!');
                        $this->emit('reload');
                        return;
                    }

                $cart->add([
                            'id'      => $product['id'],
                            'name'    => $product['product_name'],
                            'qty'     => 1,
                            'price'   => $this->calculate($product)['price'],
                            'weight'  => 1,
                            'options' => [
                                'product_discount'      => 0.00,
                                'product_discount_type' => 'fixed',
                                'sub_total'             => $this->calculate($product)['sub_total'],
                                'code'                  => $product['product_code'],
                                'stock'                 => $product['product_quantity'],
                                'unit'                  => $product['product_unit'],
                                'product_tax'           => $this->calculate($product)['product_tax'],
                                'rfid'                  => $product['rfid'],
                                'unit_price'            => $this->calculate($product)['unit_price'],
                                'location'  => 0,
                                'gambar'  => 0

                            ]
                        ]);

                 $this->check_quantity[$product['id']] = $product['product_quantity'];
                 $this->quantity[$product['id']] = 1;
                 $this->discount_type[$product['id']] = 'fixed';
                 $this->item_discount[$product['id']] = 0;
                 $this->emit('addRfid', $product['id']);
            }

            } else {
                 session()->flash('message', 'Product tidak ada!');
                        $this->emit('reload');
                        return;
            }



    }

    public function gambar($product) {
          $img = $product['media'];
             return $img;
        }
 public function productSelectedBackup($product) {
        $cart = Cart::instance($this->cart_instance);
        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
         return $cartItem->id == $product['id'];
           //dd($product);
        });
        if ($exists->isNotEmpty()) {
            session()->flash('message', 'Product sudah ada di List!');
             $this->emit('reload');
            return;
        }
        if ($exists->isEmpty()) {
            session()->flash('message', 'Product tidak ada!');
             $this->emit('reload');
            return;
        }
         if (!$product) {
            session()->flash('message', 'Product tidak ada!');
             $this->emit('reload');
            return;
        }

         if ($product && $product["id"] == '') {
            session()->flash('message', 'Product tidak ada!');
             $this->emit('reload');
            return;
        }

        $cart->add([
            'id'      => $product['id'],
            'name'    => $product['product_name'],
            'qty'     => 1,
            'price'   => $this->calculate($product)['price'],
            'weight'  => 1,
            'options' => [
                'product_discount'      => 0.00,
                'product_discount_type' => 'fixed',
                'sub_total'             => $this->calculate($product)['sub_total'],
                'code'                  => $product['product_code'],
                'stock'                 => $product['product_quantity'],
                'unit'                  => $product['product_unit'],
                'product_tax'           => $this->calculate($product)['product_tax'],
                'rfid'                  => $product['rfid'],
                'unit_price'            => $this->calculate($product)['unit_price'],
                'location'  => 0,
                'image'  =>$this->gambar($product)
            ]
        ]);

        $this->check_quantity[$product['id']] = $product['product_quantity'];
        $this->quantity[$product['id']] = 1;
        $this->discount_type[$product['id']] = 'fixed';
        $this->item_discount[$product['id']] = 0;
    }

    public function removeItem($row_id) {
        Cart::instance($this->cart_instance)->remove($row_id);
        $this->emit('reload');
    }

        public function addProduk($value)
            {
               $this->add_produk = $value;
               //dd($value);
               //$product = Product::findOrFail($value);
               $this->productSelected($value);
            }



    public function updatedGlobalTax() {
        Cart::instance($this->cart_instance)->setGlobalTax((integer)$this->global_tax);
    }

    public function updatedGlobalDiscount() {
        Cart::instance($this->cart_instance)->setGlobalDiscount((integer)$this->global_discount);
    }

    public function updateQuantity($row_id, $product_id) {
        if  ($this->cart_instance == 'sale' || $this->cart_instance == 'purchase_return') {
            if ($this->check_quantity[$product_id] < $this->quantity[$product_id]) {
                session()->flash('message', 'The requested quantity is not available in stock.');
                return;
            }
        }

        Cart::instance($this->cart_instance)->update($row_id, $this->quantity[$product_id]);

        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        Cart::instance($this->cart_instance)->update($row_id, [
            'options' => [
                'sub_total'             => $cart_item->price * $cart_item->qty,
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
                'location'              => $cart_item->options->location,
            ]
        ]);
    }


    public function updatedDiscountType($value, $name) {
        $this->item_discount[$name] = 0;
    }

    public function discountModalRefresh($product_id, $row_id) {
        $this->updateQuantity($row_id, $product_id);
    }

    public function setProductDiscount($row_id, $product_id) {
        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        if ($this->discount_type[$product_id] == 'fixed') {
            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $this->item_discount[$product_id]
                ]);

            $discount_amount = $this->item_discount[$product_id];

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        } elseif ($this->discount_type[$product_id] == 'percentage') {
            $discount_amount = ($cart_item->price + $cart_item->options->product_discount) * ($this->item_discount[$product_id] / 100);

            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $discount_amount
                ]);

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        }

        session()->flash('discount_message' . $product_id, 'Discount added to the product!');
    }

    public function calculate($product) {
        $price = 0;
        $unit_price = 0;
        $product_tax = 0;
        $sub_total = 0;

        if ($product['product_tax_type'] == 1) {
            $price = $product['product_price'] + ($product['product_price'] * ($product['product_order_tax'] / 100));
            $unit_price = $product['product_price'];
            $product_tax = $product['product_price'] * ($product['product_order_tax'] / 100);
            $sub_total = $product['product_price'] + ($product['product_price'] * ($product['product_order_tax'] / 100));
        } elseif ($product['product_tax_type'] == 2) {
            $price = $product['product_price'];
            $unit_price = $product['product_price'] - ($product['product_price'] * ($product['product_order_tax'] / 100));
            $product_tax = $product['product_price'] * ($product['product_order_tax'] / 100);
            $sub_total = $product['product_price'];
        } else {
            $price = $product['product_price'];
            $unit_price = $product['product_price'];
            $product_tax = 0.00;
            $sub_total = $product['product_price'];
        }

        return ['price' => $price, 'unit_price' => $unit_price, 'product_tax' => $product_tax, 'sub_total' => $sub_total];
    }

    public function updateCartOptions($row_id, $product_id, $cart_item, $discount_amount) {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'sub_total'             => $cart_item->price * $cart_item->qty,
            'code'                  => $cart_item->options->code,
            'stock'                 => $cart_item->options->stock,
            'unit'                  => $cart_item->options->unit,
            'product_tax'           => $cart_item->options->product_tax,
            'unit_price'            => $cart_item->options->unit_price,
            'product_discount'      => $discount_amount,
            'product_discount_type' => $this->discount_type[$product_id],
            'location'              => $cart_item->options->location,
        ]]);
    }
}
