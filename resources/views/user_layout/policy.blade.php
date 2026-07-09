@extends('user_layout.layouts.app')

@section('meta')
    <meta name="description" content="Chính sách Quyền riêng tư và Điều khoản dịch vụ của Công ty TNHH Thạch Khiết Minh.">
@endsection

@section('content')
<div class="container">
    <div class="policy-wrapper">
        <h1>{{ translate('Điều khoản và Chính sách Quyền riêng tư') }}</h1>
        <p class="policy-updated">{{ translate('Cập nhật lần cuối') }}: {{ date('d/m/Y') }}</p>

        <p>
            Bắc Trang vận hành cửa hàng và trang web này, bao gồm tất cả thông tin, nội dung, tính năng,
            công cụ, sản phẩm và dịch vụ liên quan nhằm mang đến cho bạn, khách hàng, một trải nghiệm mua sắm
            được tuyển chọn. Chính sách Quyền riêng tư này mô tả cách chúng tôi thu thập, sử dụng và tiết lộ
            thông tin cá nhân của bạn khi bạn truy cập, sử dụng, mua hàng hoặc thực hiện giao dịch khác thông
            qua Dịch vụ hoặc khi liên hệ với chúng tôi. Nếu có bất kỳ xung đột nào giữa Điều khoản Dịch vụ và
            Chính sách Quyền riêng tư này, thì Chính sách Quyền riêng tư sẽ được ưu tiên áp dụng đối với việc
            thu thập, xử lý và tiết lộ thông tin cá nhân của bạn.
        </p>
        <p>
            Vui lòng đọc kỹ Chính sách Quyền riêng tư này. Khi sử dụng và truy cập bất kỳ Dịch vụ nào, bạn
            xác nhận rằng mình đã đọc và hiểu việc thu thập, sử dụng và tiết lộ thông tin của bạn như được
            mô tả trong Chính sách này.
        </p>

        <h2>Thông tin cá nhân chúng tôi thu thập hoặc xử lý</h2>
        <p>
            Khi sử dụng thuật ngữ "thông tin cá nhân", chúng tôi đề cập đến thông tin nhận dạng bạn hoặc có
            thể được liên kết hợp lý với bạn hoặc một người khác. Thông tin cá nhân không bao gồm dữ liệu
            được thu thập ẩn danh hoặc đã được loại bỏ thông tin nhận dạng để không thể xác định hoặc liên
            kết với bạn.
        </p>
        <p>
            Tùy theo cách bạn tương tác với Dịch vụ, nơi bạn sinh sống và theo quy định pháp luật hiện hành,
            chúng tôi có thể thu thập hoặc xử lý các loại thông tin cá nhân sau:
        </p>
        <ul>
            <li><strong>Thông tin liên hệ:</strong> họ tên, địa chỉ, địa chỉ thanh toán, địa chỉ giao hàng, số điện thoại và email.</li>
            <li><strong>Thông tin tài chính:</strong> số thẻ tín dụng/thẻ ghi nợ, thông tin tài khoản tài chính, thông tin thanh toán, chi tiết giao dịch, phương thức thanh toán, xác nhận thanh toán và các thông tin thanh toán khác.</li>
            <li><strong>Thông tin tài khoản:</strong> tên đăng nhập, mật khẩu, tùy chọn và cài đặt.</li>
            <li><strong>Thông tin giao dịch:</strong> các sản phẩm bạn xem, thêm vào giỏ hàng, danh sách yêu thích, mua, trả lại, đổi hoặc hủy và lịch sử giao dịch trước đó.</li>
            <li><strong>Thông tin liên lạc với chúng tôi:</strong> nội dung bạn gửi khi liên hệ hỗ trợ khách hàng.</li>
            <li><strong>Thông tin thiết bị:</strong> thông tin về thiết bị, trình duyệt, kết nối mạng, địa chỉ IP và các mã định danh khác.</li>
            <li><strong>Thông tin sử dụng:</strong> cách bạn tương tác hoặc điều hướng trong Dịch vụ.</li>
        </ul>

        <h2>Nguồn thu thập thông tin cá nhân</h2>
        <p>Chúng tôi có thể thu thập thông tin cá nhân từ các nguồn sau:</p>
        <ul>
            <li>Trực tiếp từ bạn khi bạn tạo tài khoản, sử dụng Dịch vụ, liên hệ với chúng tôi hoặc tự cung cấp thông tin cá nhân.</li>
            <li>Tự động thông qua Dịch vụ, bao gồm dữ liệu từ thiết bị của bạn khi sử dụng sản phẩm/dịch vụ hoặc truy cập trang web của chúng tôi, cũng như thông qua cookie và công nghệ tương tự.</li>
            <li>Từ các nhà cung cấp dịch vụ của chúng tôi khi họ hỗ trợ công nghệ hoặc xử lý thông tin cá nhân thay mặt chúng tôi.</li>
            <li>Từ các đối tác hoặc bên thứ ba khác.</li>
        </ul>

        <h2>Cách chúng tôi sử dụng thông tin cá nhân của bạn</h2>
        <p>
            Tùy thuộc vào cách bạn tương tác với chúng tôi hoặc Dịch vụ bạn sử dụng, chúng tôi có thể dùng
            thông tin cá nhân cho các mục đích sau:
        </p>

        <h3>Cung cấp, cá nhân hóa và cải thiện Dịch vụ</h3>
        <p>Chúng tôi sử dụng thông tin cá nhân để:</p>
        <ul>
            <li>cung cấp Dịch vụ;</li>
            <li>xử lý thanh toán;</li>
            <li>hoàn tất đơn hàng;</li>
            <li>ghi nhớ tùy chọn và sản phẩm bạn quan tâm;</li>
            <li>gửi thông báo liên quan đến tài khoản;</li>
            <li>xử lý mua hàng, đổi trả hoặc các giao dịch khác;</li>
            <li>tạo và quản lý tài khoản;</li>
            <li>sắp xếp giao hàng;</li>
            <li>cho phép bạn đăng đánh giá;</li>
            <li>tạo trải nghiệm mua sắm cá nhân hóa, chẳng hạn đề xuất sản phẩm liên quan đến các lần mua trước của bạn.</li>
        </ul>

        <h3>Tiếp thị và quảng cáo</h3>
        <p>
            Chúng tôi sử dụng thông tin cá nhân để gửi email, tin nhắn, thư quảng cáo và hiển thị quảng cáo
            trực tuyến dựa trên hoạt động của bạn trên Dịch vụ.
        </p>

        <h3>Bảo mật và phòng chống gian lận</h3>
        <p>Chúng tôi sử dụng thông tin cá nhân để:</p>
        <ul>
            <li>xác thực tài khoản;</li>
            <li>đảm bảo trải nghiệm thanh toán và mua sắm an toàn;</li>
            <li>phát hiện và xử lý hành vi gian lận, trái pháp luật hoặc độc hại;</li>
            <li>bảo vệ an toàn công cộng;</li>
            <li>bảo vệ Dịch vụ của chúng tôi.</li>
        </ul>
        <p>
            Nếu bạn đăng ký tài khoản, bạn có trách nhiệm bảo mật thông tin đăng nhập của mình. Chúng tôi
            khuyến nghị không chia sẻ tên đăng nhập hoặc mật khẩu với bất kỳ ai.
        </p>

        <h3>Liên lạc với bạn</h3>
        <p>
            Chúng tôi sử dụng thông tin cá nhân để hỗ trợ khách hàng, phản hồi yêu cầu và duy trì quan hệ
            kinh doanh với bạn.
        </p>

        <h3>Lý do pháp lý</h3>
        <p>
            Chúng tôi có thể sử dụng thông tin cá nhân để tuân thủ pháp luật, phản hồi yêu cầu từ cơ quan
            chức năng, tham gia tố tụng pháp lý hoặc thực thi điều khoản và chính sách của chúng tôi.
        </p>

        <h2>Cách chúng tôi tiết lộ thông tin cá nhân</h2>
        <p>
            Trong một số trường hợp, chúng tôi có thể chia sẻ thông tin cá nhân với bên thứ ba cho các mục
            đích hợp pháp, bao gồm:
        </p>
        <ul>
            <li>Với Bắc Trang, đối tác cung cấp dịch vụ thay mặt chúng tôi (ví dụ: quản lý CNTT, xử lý thanh toán, phân tích dữ liệu, hỗ trợ khách hàng, lưu trữ đám mây, giao hàng).</li>
            <li>Khi bạn yêu cầu hoặc đồng ý chia sẻ thông tin với bên thứ ba, ví dụ để giao hàng hoặc thông qua tích hợp mạng xã hội.</li>
            <li>Trong các giao dịch doanh nghiệp như sáp nhập hoặc phá sản, hoặc để tuân thủ nghĩa vụ pháp lý và bảo vệ quyền lợi của chúng tôi.</li>
        </ul>

        <h2>Trang web và liên kết bên thứ ba</h2>
        <p>
            Dịch vụ có thể chứa liên kết đến các trang web hoặc nền tảng của bên thứ ba. Nếu bạn truy cập
            các liên kết này, bạn nên xem xét chính sách quyền riêng tư và bảo mật của họ. Chúng tôi không
            chịu trách nhiệm về nội dung hoặc độ an toàn của các trang web đó.
        </p>

        <h2>Bảo mật và lưu giữ thông tin</h2>
        <p>
            Không có biện pháp bảo mật nào là hoàn hảo tuyệt đối, và chúng tôi không thể đảm bảo "bảo mật
            tuyệt đối". Chúng tôi khuyến nghị không gửi thông tin nhạy cảm qua các kênh không an toàn.
        </p>
        <p>Thời gian lưu giữ thông tin cá nhân phụ thuộc vào nhiều yếu tố như:</p>
        <ul>
            <li>duy trì tài khoản;</li>
            <li>cung cấp Dịch vụ;</li>
            <li>tuân thủ pháp luật;</li>
            <li>giải quyết tranh chấp;</li>
            <li>thực thi hợp đồng và chính sách.</li>
        </ul>

        <h2>Quyền và lựa chọn của bạn</h2>
        <p>Tùy theo nơi cư trú, bạn có thể có một số quyền sau:</p>
        <ul>
            <li>Quyền truy cập thông tin cá nhân.</li>
            <li>Quyền yêu cầu xóa dữ liệu.</li>
            <li>Quyền chỉnh sửa thông tin không chính xác.</li>
            <li>Quyền nhận bản sao dữ liệu và chuyển cho bên thứ ba.</li>
            <li>Quyền từ chối việc bán/chia sẻ dữ liệu cho quảng cáo nhắm mục tiêu.</li>
            <li>Quyền quản lý tùy chọn liên lạc và từ chối email quảng cáo.</li>
        </ul>
        <p>Chúng tôi có thể cần xác minh danh tính trước khi xử lý yêu cầu của bạn.</p>

        <h2>Khiếu nại</h2>
        <p>
            Nếu bạn có khiếu nại về cách chúng tôi xử lý thông tin cá nhân, vui lòng liên hệ với chúng tôi.
            Tùy theo nơi bạn sống, bạn cũng có thể khiếu nại với cơ quan bảo vệ dữ liệu địa phương.
        </p>

        <h2>Thay đổi Chính sách Quyền riêng tư</h2>
        <p>
            Chúng tôi có thể cập nhật Chính sách Quyền riêng tư theo thời gian để phản ánh thay đổi trong
            hoạt động hoặc yêu cầu pháp lý. Phiên bản cập nhật sẽ được đăng trên trang web cùng ngày cập
            nhật mới nhất.
        </p>

        <h2>Liên hệ</h2>
        <p>
            Nếu bạn có câu hỏi về Chính sách Quyền riêng tư hoặc muốn thực hiện quyền của mình, vui lòng
            liên hệ với chúng tôi qua các kênh hỗ trợ khách hàng hiển thị trên trang web.
        </p>
    </div>
</div>
@endsection
