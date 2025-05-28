<div>
    <section class="contact-section spad" id="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title contact-title">
                        <span>Contact Us</span>
                        <h2>GET IN TOUCH</h2>
                    </div>
                    <div class="contact-widget">
                        <div class="cw-text">
                            <i class="fa fa-map-marker"></i>
                            <p>Zone 5, AFP Housing </br>
                                Bulihan, Silang, Cavite</p>
                        </div>
                        <div class="cw-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>0912 123 6182</li>
                            </ul>
                        </div>
                        <div class="cw-text email">
                            <i class="fa fa-envelope"></i>
                            <p>jeremiahpanganibanr@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="leave-comment">
                        <form wire:submit.prevent="submit">
                            @if (session()->has('message'))
                                <div class="alert alert-success mb-3">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <input type="text" placeholder="Name" wire:model.defer="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="text" placeholder="Email" wire:model.defer="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <textarea placeholder="Message" wire:model.defer="message"></textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <button type="submit" wire:loading.attr="disabled" wire:target="submit">
                                <span wire:loading.remove wire:target="submit">Submit</span>
                                <span wire:loading wire:target="submit">
                                    <i class="fa fa-spinner fa-spin"></i> Submitting...
                                </span>
                            </button>
                        </form>
                        @if (session()->has('success-message'))
                            <div x-data="{ show: true }" x-init="$watch('show', value => {
                                if (!value) $el.remove(); // Remove element when hidden
                            });
                            setTimeout(() => show = false, 3000);" x-show="show"
                                class="alert alert-success">
                                {{ session('success-message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12087.069761554938!2d-74.2175599360452!3d40.767139456514954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c254b5958982c3%3A0xb6ab3931055a2612!2sEast%20Orange%2C%20NJ%2C%20USA!5e0!3m2!1sen!2sbd!4v1581710470843!5m2!1sen!2sbd"
                    height="550" style="border:0;" allowfullscreen=""></iframe>
            </div> --}}
        </div>
    </section>
</div>
